<?php

namespace App\Http\Controllers\Site;

use App\Enums\TransactionRequestType;
use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Models\Plan;
use App\Models\Review;
use App\Models\TransactionRequest;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SiteController extends Controller
{
    public function index()
    {
        $plans = $this->accountPlans();
        $defaultReviews = collect([
            [
                'name' => 'Jonathan C.',
                'date' => '2025-07-25',
                'text' => 'You can find all you need here. A wide range of trading instruments and indicators. The interface is intuitive, easy to get everything. I can give a recommendation, the best one in the world!',
                'rating' => 5,
            ],
            [
                'name' => 'Ahmed K.',
                'date' => '2026-01-10',
                'text' => 'منصة ممتازة جداً وسرعة في السحب والايداع. قسم الدعم الفني متجاوب دائماً وحل لجميع مشاكلي في دقائق.',
                'rating' => 5,
            ],
            [
                'name' => 'Sarah M.',
                'date' => '2026-03-05',
                'text' => 'I have tried many platforms, but ' . appName() . ' stands out with its seamless experience and incredible accuracy.',
                'rating' => 5,
            ],
        ]);

        $reviewsFeatureEnabled = Schema::hasTable('reviews');
        $userHasReview = false;
        $userReviews = collect();

        if ($reviewsFeatureEnabled) {
            $userReviews = Review::query()
                ->with('user:id,first_name,last_name')
                ->latest()
                ->get()
                ->map(function (Review $review) {
                    return [
                        'name' => $review->user?->full_name ?? 'مستخدم ' . appName(),
                        'date' => $review->created_at?->format('Y-m-d') ?? now()->format('Y-m-d'),
                        'text' => $review->text,
                        'rating' => $review->rating,
                    ];
                });

            $userHasReview = Auth::check()
                ? Review::where('user_id', Auth::id())->exists()
                : false;
        }

        $reviews = $userReviews
            ->concat($defaultReviews)
            ->take(10)
            ->values();

        return view('site.home', compact('plans', 'reviews', 'userHasReview', 'reviewsFeatureEnabled'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Get user's wallet IDs for direct transaction queries
        $walletIds = $user->wallets()->pluck('id');

        // 1. Stats Setup
        $mainBalance = $user->deposit_balance;
        $profitBalance = $user->profit_balance;
        $totalDeposits = \App\Models\Transaction::whereIn('wallet_id', $walletIds)
            ->where('type', \App\Enums\TransactionType::Deposit)
            ->where('status', \App\Enums\TransactionStatus::Accepted)
            ->sum('amount');
        $totalWithdrawals = \App\Models\Transaction::whereIn('wallet_id', $walletIds)
            ->where('type', \App\Enums\TransactionType::Withdrawal)
            ->where('status', \App\Enums\TransactionStatus::Accepted)
            ->sum('amount');

        // 2. Line Chart: Profits (Last 30 Days)
        $profitsOverTime = \App\Models\Transaction::whereIn('wallet_id', $walletIds)
            ->where('type', \App\Enums\TransactionType::Profit)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $profitDates = [];
        $profitTotals = [];

        // Fill last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $profitDates[] = Carbon::parse($date)->format('M d'); // Better readable format
            $match = $profitsOverTime->firstWhere('date', $date);
            $profitTotals[] = $match ? round($match->total, 2) : 0;
        }

        // 3. Bar Chart: Deposits vs Withdrawals (Last 6 Months)
        $sixMonthsAgo = now()->subMonths(6)->startOfMonth();

        $monthsList = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthsList[] = now()->subMonths($i)->format('Y-m');
        }

        $monthlyDW = \App\Models\Transaction::whereIn('wallet_id', $walletIds)
            ->whereIn('type', [\App\Enums\TransactionType::Deposit, \App\Enums\TransactionType::Withdrawal])
            ->where('status', \App\Enums\TransactionStatus::Accepted)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, type, SUM(amount) as total')
            ->groupBy('month', 'type')
            ->get();

        $depositData = array_fill_keys($monthsList, 0);
        $withdrawData = array_fill_keys($monthsList, 0);

        foreach ($monthlyDW as $row) {
            if ($row->type == \App\Enums\TransactionType::Deposit) {
                $depositData[$row->month] = $row->total;
            } elseif ($row->type == \App\Enums\TransactionType::Withdrawal) {
                $withdrawData[$row->month] = $row->total;
            }
        }
        $barMonths = array_values($monthsList);
        $barDeposits = array_values($depositData);
        $barWithdrawals = array_values($withdrawData);

        // 4. Tables Data
        $latestTransactions = $user->transactions()->with(['transactionRequest', 'wallet'])
            ->latest()
            ->take(10)
            ->get();

        $pendingRequests = $user->requests()
            ->where('status', \App\Enums\TransactionStatus::Pending)
            ->latest()
            ->get();

        // 5. Widgets Data
        $referredCount = $user->referrals()->count();
        $referralEarnings = $user->referralEarnings()->sum('amount');

        $unreadMessages = $user->receivedMessages()
            ->where('is_read', false)
            ->latest()
            ->take(3)
            ->get();

        $activeTrades = $user->trades()->where('is_active', true)->latest()->get();
        $closedTrades = $user->trades()->where('is_active', false)->latest()->take(10)->get();

        // Recent trades for dashboard (last 10 closed trades with PnL)
        $recentTrades = $user->trades()
            ->where('is_active', false)
            ->whereNotNull('pnl')
            ->latest('closed_at')
            ->take(10)
            ->get();

        // Calculate AI confidence based on real metrics
        $plan = $user->plan;
        $aiConfidence = 0;
        if ($plan && $user->status !== \App\Enums\UserStatus::Pending && $user->status !== \App\Enums\UserStatus::Inactive) {
            // Base confidence on plan type
            $baseConfidence = 75;
            
            // Add points for completed trades
            $tradeCount = $user->trades()->where('is_active', false)->count();
            $tradeBonus = min(10, $tradeCount * 0.5); // Up to 10 points
            
            // Add points for profitable trades
            $profitableTrades = $user->trades()->where('is_active', false)->where('pnl', '>', 0)->count();
            $winRate = $tradeCount > 0 ? ($profitableTrades / $tradeCount) : 0;
            $winRateBonus = $winRate * 15; // Up to 15 points
            
            $aiConfidence = min(97, round($baseConfidence + $tradeBonus + $winRateBonus));
        } else {
            $aiConfidence = 0;
        }

        return view('site.dashboard', compact(
            'user',
            'mainBalance',
            'profitBalance',
            'totalDeposits',
            'totalWithdrawals',
            'profitDates',
            'profitTotals',
            'barMonths',
            'barDeposits',
            'barWithdrawals',
            'latestTransactions',
            'pendingRequests',
            'referredCount',
            'referralEarnings',
            'unreadMessages',
            'activeTrades',
            'closedTrades',
            'recentTrades',
            'aiConfidence'
        ));
    }

    public function depositShow()
    {
        $user = Auth::user();

        return view('site.funding', compact('user'));
    }

    public function fundingShow(Request $request)
    {
        return redirect()->route('site.deposit');
    }

    public function fundingStore(DepositRequest $request)
    {
        try {
            $user = Auth::user();

            if ($this->isDemoAccount($user)) {
                return redirect()
                    ->route('site.deposit')
                    ->with('warning', 'الحساب التجريبي لا يمكنه تنفيذ عمليات مالية. يرجى إنشاء حساب حقيقي أو تسجيل الدخول بحساب حقيقي.');
            }

            $proofPath = $request->file('payment_proof')->store('payment_proofs');

            DB::beginTransaction();
            TransactionRequest::create([
                'user_id' => $user->id,
                'type' => TransactionRequestType::Deposit->value,
                'method' => $request->payment_method,
                'amount' => $request->amount,
                'image' => $proofPath,
                'status' => TransactionStatus::Pending->value,
            ]);
            DB::commit();

            return redirect()
                ->route('site.wallet')
                ->with('success', 'تم إرسال طلب الإيداع بنجاح. بعد المراجعة سيتم إضافة الرصيد إلى محفظتك خلال 15 دقيقة، وبعدها يمكنك تحويله للتداول أو تخصيصه للروبوت أو الاشتراك في خطة استثمار.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Deposit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدثت مشكلة أثناء إرسال طلب الإيداع، الرجاء المحاولة لاحقًا.');
        }
    }

    public function deposit(DepositRequest $request)
    {
        return $this->fundingStore($request);
    }

    public function storeReview(Request $request)
    {
        if (!Schema::hasTable('reviews')) {
            return back()->with('error', 'ميزة التقييم غير متاحة حالياً.');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'text' => ['required', 'string', 'max:500'],
        ]);

        if (Review::where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'لقد أضفت تقييمك بالفعل');
        }

        Review::create([
            'user_id' => Auth::id(),
            'rating' => (int) $request->integer('rating'),
            'text' => $request->string('text')->trim()->toString(),
        ]);

        return back()->with('success', 'تم إضافة تقييمك بنجاح!');
    }

    private function accountPlans()
    {
        return Plan::query()->accountPlans()->get();
    }

    private function resolveSelectedPlan(Request $request, $plans, ?int $fallbackPlanId = null)
    {
        $requestedPlanId = (int) ($request->integer('plan_id') ?: $request->integer('plan'));
        $candidatePlanId = $requestedPlanId ?: (int) $fallbackPlanId;

        return $plans->firstWhere('id', $candidatePlanId) ?? $plans->first();
    }

    private function isDemoAccount($user): bool
    {
        return (bool) ($user?->is_demo ?? false);
    }
}
