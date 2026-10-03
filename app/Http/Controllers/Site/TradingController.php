<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TradingController extends Controller
{
    public function transferToTrading(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

        if ((bool) ($user->is_demo ?? false)) {
            return response()->json([
                'success' => false,
                'message' => 'الحساب التجريبي لا يمكنه تنفيذ عمليات مالية. يرجى إنشاء حساب حقيقي أو تسجيل الدخول بحساب حقيقي.',
            ], 403);
        }
        
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);
        
        $depositWallet = $user->depositWallet;
        
        if (!$depositWallet || $depositWallet->balance < $request->amount) {
            return response()->json(['success' => false, 'message' => 'رصيد المحفظة غير كافي']);
        }
        
        try {
            DB::transaction(function () use ($user, $depositWallet, $request) {
                // 1. Add to Trading Balance (Wallet subtraction is handled by TransactionObserver)
                $user->increment('trading_balance', $request->amount);
                
                // 3. Record Transaction
                $depositWallet->transactions()->create([
                    'type' => TransactionType::InternalTransfer->value,
                    'status' => TransactionStatus::Accepted,
                    'amount' => $request->amount,
                    'description' => "تحويل إلى رصيد التداول: $request->amount $",
                    'transaction_date' => now(),
                ]);
            });
            
            return response()->json([
                'success' => true, 
                'message' => 'تم شحن رصيد التداول بنجاح',
                'trading_balance' => number_format($user->fresh()->trading_balance, 2),
                'wallet_balance' => number_format($depositWallet->fresh()->balance, 2)
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء التحويل']);
        }
    }

    public function transferFromTrading(\Illuminate\Http\Request $request)
    {
        $authUser = Auth::user();

        if ((bool) ($authUser->is_demo ?? false)) {
            return back()->with('warning', 'الحساب التجريبي لا يمكنه تنفيذ عمليات مالية. يرجى إنشاء حساب حقيقي أو تسجيل الدخول بحساب حقيقي.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:1000000000'],
        ], [
            'amount.required' => 'المبلغ مطلوب.',
            'amount.numeric' => 'المبلغ يجب أن يكون رقمًا.',
            'amount.min' => 'المبلغ يجب أن يكون على الأقل ' . formatCurrency(1) . '.',
        ]);

        $amount = round((float) $validated['amount'], 2);

        try {
            DB::transaction(function () use ($authUser, $amount) {
                $user = User::whereKey($authUser->id)->lockForUpdate()->firstOrFail();

                if ((float) $user->trading_balance < $amount) {
                    throw new \RuntimeException('رصيد التداول غير كافٍ لإتمام التحويل.');
                }

                $user->trading_balance = round((float) $user->trading_balance - $amount, 2);
                $user->save();

                $profitWallet = $user->wallets()
                    ->where('type', WalletType::Profit)
                    ->lockForUpdate()
                    ->first();

                if (!$profitWallet) {
                    $profitWallet = Wallet::create([
                        'user_id' => $user->id,
                        'type' => WalletType::Profit,
                        'balance' => 0,
                    ]);
                }

                $profitWallet->transactions()->create([
                    'type' => TransactionType::Profit->value,
                    'status' => TransactionStatus::Accepted->value,
                    'amount' => $amount,
                    'description' => 'تحويل من رصيد التداول إلى محفظة الأرباح',
                    'transaction_date' => now(),
                ]);
            });
        } catch (\RuntimeException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return back()->with('success', 'تم تحويل المبلغ من رصيد التداول إلى محفظة الأرباح بنجاح. يمكنك الآن إرسال طلب سحب.');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $activeTrades = $user->trades()->where('is_active', true)->latest()->get();
        $closedTrades = $user->trades()->where('is_active', false)->latest()->paginate(15);
        
        $priceChange = 12.50; // Mock data for blade
        $priceChangePct = 0.45; // Mock data for blade

        return view('site.trading', compact('user', 'activeTrades', 'closedTrades', 'priceChange', 'priceChangePct'));
    }

    public function history()
    {
        $user = Auth::user();

        $closedTrades = $user->trades()
            ->where('is_active', false)
            ->whereNotNull('pnl')
            ->latest('closed_at')
            ->paginate(20);

        $summaryTrades = $user->trades()
            ->where('is_active', false)
            ->whereNotNull('pnl')
            ->get();

        $totalTrades = $summaryTrades->count();
        $winningTrades = $summaryTrades->where('pnl', '>', 0)->count();
        $losingTrades = $summaryTrades->where('pnl', '<=', 0)->count();
        $netPnl = (float) $summaryTrades->sum('pnl');
        $winRate = $totalTrades > 0 ? round(($winningTrades / $totalTrades) * 100, 1) : 0;

        return view('site.trading-history', compact(
            'closedTrades',
            'totalTrades',
            'winningTrades',
            'losingTrades',
            'netPnl',
            'winRate'
        ));
    }

    public function openTrade(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:buy,sell',
            'strike_price' => 'required|numeric',
            'symbol' => 'nullable|string|max:20',
            'mode' => 'nullable|in:real,demo',
        ]);

        $mode = ((bool) ($user->is_demo ?? false))
            ? 'demo'
            : $request->input('mode', 'real');

        if ($mode === 'real' && (bool) ($user->is_demo ?? false)) {
            return response()->json(['success' => false, 'message' => 'الحساب التجريبي يمكنه التداول التجريبي فقط.'], 403);
        }

        $balanceField = $mode === 'demo' ? 'demo_trading_balance' : 'trading_balance';

        try {
            $result = DB::transaction(function () use ($user, $request, $mode, $balanceField) {
                $lockedUser = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
                $amount = round((float) $request->amount, 2);

                if ((float) $lockedUser->{$balanceField} < $amount) {
                    throw new \RuntimeException('لا تملك رصيد كافي للتداول');
                }

                $lockedUser->{$balanceField} = round((float) $lockedUser->{$balanceField} - $amount, 2);
                $lockedUser->save();

                do {
                    $ticket = 'T' . strtoupper(Str::random(12));
                } while ($lockedUser->trades()->where('ticket', $ticket)->exists());

                $lockedUser->trades()->create([
                    'ticket' => $ticket,
                    'symbol' => $request->input('symbol', 'XAUUSD'),
                    'is_demo' => $mode === 'demo',
                    'type' => $request->type,
                    'open_price' => $request->strike_price,
                    'lot_size' => $amount,
                    'is_active' => true,
                ]);

                return [
                    'ticket' => $ticket,
                    'balance' => (float) $lockedUser->{$balanceField},
                ];
            });
        } catch (\RuntimeException $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
        
        return response()->json([
            'success' => true, 
            'ticket' => $result['ticket'], 
            'mode' => $mode,
            'balance' => $result['balance'],
        ]);
    }

    public function closeTrade(\Illuminate\Http\Request $request, $ticket)
    {
        $user = Auth::user();
        
        $request->validate([
            'close_price' => 'required|numeric',
            'mode' => 'nullable|in:real,demo',
        ]);

        try {
            $result = DB::transaction(function () use ($user, $request, $ticket) {
                $lockedUser = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
                $trade = $lockedUser->trades()
                    ->where('ticket', $ticket)
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (!$trade) {
                    throw new \RuntimeException('Trade not found or already closed');
                }

                $mode = $trade->is_demo ? 'demo' : 'real';
                if ((bool) ($lockedUser->is_demo ?? false) && $mode !== 'demo') {
                    throw new \RuntimeException('الحساب التجريبي يمكنه التداول التجريبي فقط.');
                }

                $balanceField = $mode === 'demo' ? 'demo_trading_balance' : 'trading_balance';

                $isWin = false;
                if ($trade->type == 'buy' && $request->close_price > $trade->open_price) {
                    $isWin = true;
                } elseif ($trade->type == 'sell' && $request->close_price < $trade->open_price) {
                    $isWin = true;
                }

                $profitMultiplier = 1.92; // Default 92% profit, matching the trading UI
                $payout = 0;

                if ($isWin) {
                    $payout = round((float) $trade->lot_size * $profitMultiplier, 2);
                    $pnl = round($payout - (float) $trade->lot_size, 2);
                    $lockedUser->{$balanceField} = round((float) $lockedUser->{$balanceField} + $payout, 2);
                } else {
                    $pnl = round(-1 * (float) $trade->lot_size, 2);
                }

                $lockedUser->save();

                $trade->update([
                    'close_price' => $request->close_price,
                    'pnl' => $pnl,
                    'is_active' => false,
                    'closed_at' => now(),
                ]);

                $direction = strtoupper($trade->type);
                $formattedPnl = number_format((float) $pnl, 2);
                $signedPnl = ($pnl > 0 ? '+' : '') . '$' . $formattedPnl;
                $formattedBalance = '$' . number_format((float) $lockedUser->{$balanceField}, 2);
                $resultWord = $isWin ? 'won' : 'lost';

                if ($mode === 'real') {
                    $lockedUser->notifications()->create([
                        'type' => 'trade_closed',
                        'title' => $isWin ? 'Deal won' : 'Deal lost',
                        'body' => "{$trade->symbol} {$direction} finished. " . ($isWin ? 'Profit' : 'Loss') . ": {$signedPnl}. Balance: {$formattedBalance}.",
                        'data' => [
                            'ticket' => $trade->ticket,
                            'symbol' => $trade->symbol,
                            'type' => $trade->type,
                            'amount' => (float) $trade->lot_size,
                            'open_price' => (float) $trade->open_price,
                            'close_price' => (float) $request->close_price,
                            'pnl' => (float) $pnl,
                            'is_win' => $isWin,
                            'balance' => (float) $lockedUser->{$balanceField},
                        ],
                    ]);
                }

                return compact('trade', 'mode', 'isWin', 'pnl', 'payout', 'direction', 'signedPnl', 'formattedBalance', 'resultWord') + [
                    'balance' => (float) $lockedUser->{$balanceField},
                ];
            });
        } catch (\RuntimeException $exception) {
            $status = $exception->getMessage() === 'الحساب التجريبي يمكنه التداول التجريبي فقط.' ? 403 : 200;
            return response()->json(['success' => false, 'message' => $exception->getMessage()], $status);
        }
        
        return response()->json([
            'success' => true, 
            'pnl' => $result['pnl'], 
            'isWin' => $result['isWin'], 
            'result' => $result['isWin'] ? 'win' : 'loss',
            'ticket' => $result['trade']->ticket,
            'symbol' => $result['trade']->symbol,
            'type' => $result['trade']->type,
            'amount' => (float) $result['trade']->lot_size,
            'open_price' => (float) $result['trade']->open_price,
            'close_price' => (float) $request->close_price,
            'payout' => $result['isWin'] ? $result['payout'] : 0,
            'mode' => $result['mode'],
            'balance' => $result['balance'],
            'message' => "{$result['trade']->symbol} {$result['direction']} {$result['resultWord']}. " . ($result['isWin'] ? 'Profit' : 'Loss') . ": {$result['signedPnl']}. Balance: {$result['formattedBalance']}.",
        ]);
    }
}
