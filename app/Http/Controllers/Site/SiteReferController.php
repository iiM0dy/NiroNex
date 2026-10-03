<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteReferController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $referrals = $user->referrals()->latest()->paginate(10);
        $referralEarnings = $user->referralEarnings()->get();
        $totalCommission = $referralEarnings->sum('amount');
        $referralLink = route('register', ['ref' => $user->id]);

        return view('site.refers.index', compact('referrals', 'referralEarnings', 'totalCommission', 'referralLink'));
    }
}
