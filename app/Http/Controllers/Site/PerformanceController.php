<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $closedTrades = $user->trades()->where('is_active', false)->get();
        $totalTrades = $closedTrades->count();

        // Win rate
        $winningTrades = $closedTrades->where('pnl', '>', 0)->count();
        $winRate = $totalTrades > 0 ? round(($winningTrades / $totalTrades) * 100, 1) : 0;

        // Average return
        $avgReturn = $totalTrades > 0 ? round($closedTrades->avg('pnl'), 2) : 0;

        // Drawdown (simplified: max peak-to-trough in cumulative PnL)
        $drawdown = 0;
        if ($totalTrades > 0) {
            $cumulativePnl = 0;
            $peak = 0;
            $maxDrawdown = 0;
            foreach ($closedTrades->sortBy('closed_at') as $trade) {
                $cumulativePnl += $trade->pnl;
                if ($cumulativePnl > $peak) {
                    $peak = $cumulativePnl;
                }
                $dd = $peak - $cumulativePnl;
                if ($dd > $maxDrawdown) {
                    $maxDrawdown = $dd;
                }
            }
            $drawdown = $peak > 0 ? round(($maxDrawdown / $peak) * 100, 1) : 0;
        }

        // Equity curve data (cumulative PnL over time)
        $equityDates = [];
        $equityValues = [];
        $runningTotal = 0;
        foreach ($closedTrades->sortBy('closed_at') as $trade) {
            $runningTotal += $trade->pnl;
            $date = $trade->closed_at ? Carbon::parse($trade->closed_at)->format('M d') : $trade->created_at->format('M d');
            $equityDates[] = $date;
            $equityValues[] = round($runningTotal, 2);
        }

        return view('site.performance', compact(
            'user',
            'winRate',
            'avgReturn',
            'drawdown',
            'totalTrades',
            'equityDates',
            'equityValues'
        ));
    }
}
