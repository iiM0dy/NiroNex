<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\WalletType;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {


        // 1. Stat Cards
        $totalUsers = User::realUsers()->count();
        $totalDeposits = Transaction::where('type', \App\Enums\TransactionType::Deposit)
            ->where('status', \App\Enums\TransactionStatus::Accepted)
            ->whereHas('wallet.user', fn ($q) => $q->realUsers())
            ->sum('amount');
        $totalWithdrawals = Transaction::where('type', \App\Enums\TransactionType::Withdrawal)
            ->where('status', \App\Enums\TransactionStatus::Accepted)
            ->whereHas('wallet.user', fn ($q) => $q->realUsers())
            ->sum('amount');
        $pendingRequests = \App\Models\TransactionRequest::where('status', \App\Enums\TransactionStatus::Pending)
            ->whereHas('user', fn ($q) => $q->realUsers())
            ->count();

        // 2. Line chart: registrations per day (last 30 days)
        $last30Days = \Carbon\Carbon::now()->subDays(30);
        $registrationsChart = User::realUsers()
            ->where('created_at', '>=', $last30Days)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill missing days with 0
        $regLabels = [];
        $regData = [];
        for ($i = 0; $i < 30; $i++) {
            $date = \Carbon\Carbon::now()->subDays(29 - $i)->format('Y-m-d');
            $regLabels[] = \Carbon\Carbon::parse($date)->format('M d');
            $match = $registrationsChart->firstWhere('date', $date);
            $regData[] = $match ? $match->count : 0;
        }

        // Bar chart: weekly deposits vs withdrawals (last 8 weeks including this week)
        $startOfCurrentWeek = \Carbon\Carbon::now()->startOfWeek();
        $eightWeeksAgo = $startOfCurrentWeek->copy()->subWeeks(7); // Start 7 weeks before this week to get 8 weeks total

        $weeklyTransactions = Transaction::where('status', \App\Enums\TransactionStatus::Accepted)
            ->whereIn('type', [\App\Enums\TransactionType::Deposit, \App\Enums\TransactionType::Withdrawal])
            ->where('transaction_date', '>=', $eightWeeksAgo)
            ->whereHas('wallet.user', fn ($q) => $q->realUsers())
            ->get();

        $weeklyLabels = [];
        $weeklyDeposits = [];
        $weeklyWithdrawals = [];

        for ($i = 0; $i < 8; $i++) {
            $start = $eightWeeksAgo->copy()->addWeeks($i);
            $end = $start->copy()->endOfWeek();

            if ($start->isCurrentWeek()) {
                $weeklyLabels[] = 'هذا الأسبوع';
            } else {
                $weeklyLabels[] = $start->format('M d') . ' - ' . $end->format('M d');
            }

            $weeklyDeposits[] = (float) $weeklyTransactions
                ->where('type', \App\Enums\TransactionType::Deposit)
                ->filter(function ($t) use ($start, $end) {
                    return $t->transaction_date->between($start, $end);
                })
                ->sum('amount');

            $weeklyWithdrawals[] = (float) $weeklyTransactions
                ->where('type', \App\Enums\TransactionType::Withdrawal)
                ->filter(function ($t) use ($start, $end) {
                    return $t->transaction_date->between($start, $end);
                })
                ->sum('amount');
        }

        // 3. Donut charts
        $usersPerPlan = User::realUsers()
            ->whereNotNull('plan_id')
            ->with('plan')
            ->selectRaw('plan_id, COUNT(*) as count')
            ->groupBy('plan_id')
            ->get();
        $planLabels = [];
        $planData = [];
        foreach ($usersPerPlan as $up) {
            $planLabels[] = $up->plan ? $up->plan->display_name : 'Unknown';
            $planData[] = $up->count;
        }

        $requestsByStatus = \App\Models\TransactionRequest::whereHas('user', fn ($q) => $q->realUsers())
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
        $statusLabels = [];
        $statusData = [];
        $statusColors = [];
        foreach ($requestsByStatus as $rs) {
            $statusLabels[] = $rs->status->name;
            $statusData[] = $rs->count;
            if ($rs->status === \App\Enums\TransactionStatus::Pending)
                $statusColors[] = '#f59e0b';
            elseif ($rs->status === \App\Enums\TransactionStatus::Accepted)
                $statusColors[] = '#10b981';
            else
                $statusColors[] = '#e53e3e';
        }

        // 4. Tables
        $latestPendingRequests = \App\Models\TransactionRequest::with('user')
            ->where('status', \App\Enums\TransactionStatus::Pending)
            ->whereHas('user', fn ($q) => $q->realUsers())
            ->latest()
            ->take(8)
            ->get();

        $latestInternalTransfers = \App\Models\TransactionRequest::with(['user', 'receiver'])
            ->where('type', \App\Enums\TransactionRequestType::InternalTransfer)
            ->whereHas('user', fn ($q) => $q->realUsers())
            ->whereHas('receiver', fn ($q) => $q->realUsers())
            ->latest()
            ->take(8)
            ->get();

        $latestUsers = User::with('plan')
            ->realUsers()
            ->latest()
            ->take(5)
            ->get();

        // 5. Extra widgets
        $topReferrers = \App\Models\ReferralEarning::with('referrer')
            ->selectRaw('referrer_id, SUM(amount) as total_earned')
            ->groupBy('referrer_id')
            ->orderByDesc('total_earned')
            ->take(5)
            ->get();

        $kycPendingCount = User::realUsers()
            ->where('status', UserStatus::Pending)
            ->whereNotNull('id_photo_front')
            ->count();

        // Admin messages where receiver is 0 or admin ID
        $unreadMessagesCount = \App\Models\Message::where('is_read', false)
            ->whereIn('receiver_id', [0, auth()->id()])
            ->whereHas('sender', fn ($q) => $q->realUsers())
            ->count();

        $latestTransactions = Transaction::with(['wallet.user'])
            ->whereHas('wallet.user', fn ($q) => $q->realUsers())
            ->latest()
            ->take(20)
            ->get();
        $latestMessages = \App\Models\Message::with('sender')
            ->whereHas('sender', fn ($q) => $q->realUsers())
            ->latest()
            ->take(5)
            ->get();
        $profitLogs = Transaction::with(['wallet.user.plan'])
            ->where('type', \App\Enums\TransactionType::Profit)
            ->whereHas('wallet.user', fn ($q) => $q->realUsers())
            ->latest()
            ->paginate(50);

        $usersCount = $totalUsers;
        $transactionsCount = Transaction::whereHas('wallet.user', fn ($q) => $q->realUsers())->count();
        $pendingRequestsCount = $pendingRequests;
        $messagesCount = $unreadMessagesCount;
        $volumeTotal = (float) $totalDeposits + (float) $totalWithdrawals;

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDeposits',
            'totalWithdrawals',
            'pendingRequests',
            'regLabels',
            'regData',
            'weeklyLabels',
            'weeklyDeposits',
            'weeklyWithdrawals',
            'planLabels',
            'planData',
            'statusLabels',
            'statusData',
            'statusColors',
            'latestPendingRequests',
            'latestInternalTransfers',
            'latestUsers',
            'topReferrers',
            'kycPendingCount',
            'unreadMessagesCount',
            'latestTransactions',
            'latestMessages',
            'profitLogs',
            'usersCount',
            'transactionsCount',
            'pendingRequestsCount',
            'messagesCount',
            'volumeTotal'
        ));
    }
}
