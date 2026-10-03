<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;

class SiteTransactionsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $walletIds = Auth::user()->wallets->pluck('id')->toArray();

        $query = Transaction::whereIn('wallet_id', $walletIds);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('created_at', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10);

        return view('site.transactions.index', compact('transactions'));
    }

}
