<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->loadMissing('robotSettings');

        $depositBalance = $user->deposit_balance;
        $profitBalance = $user->profit_balance;
        $tradingBalance = (float) ($user->trading_balance ?? 0);
        $planAmount = (float) ($user->plan_amount ?? 0);
        $robotBalance = (float) ($user->robotSettings?->allocation_amount ?? 0);
        $totalBalance = $depositBalance + $profitBalance + $tradingBalance + $planAmount + $robotBalance;

        // Transaction history through wallets
        $walletIds = $user->wallets()->pluck('id');
        $transactions = \App\Models\Transaction::whereIn('wallet_id', $walletIds)
            ->with('wallet')
            ->latest()
            ->paginate(15);

        // Pending requests
        $pendingRequests = $user->requests()
            ->where('status', \App\Enums\TransactionStatus::Pending)
            ->latest()
            ->get();

        return view('site.wallet', compact(
            'user',
            'depositBalance',
            'profitBalance',
            'tradingBalance',
            'planAmount',
            'robotBalance',
            'totalBalance',
            'transactions',
            'pendingRequests'
        ));
    }
}
