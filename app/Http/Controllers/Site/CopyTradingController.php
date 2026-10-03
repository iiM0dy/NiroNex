<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CopyTradingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CopyTradingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = $user->copyTradingSetting ?? new CopyTradingSetting([
            'capital_percentage' => 10,
            'risk_level' => 'medium',
            'is_active' => false,
        ]);

        return view('site.copy-trading', compact('user', 'settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'source_account' => 'nullable|string|max:255',
            'capital_percentage' => 'required|numeric|min:1|max:100',
            'risk_level' => 'required|in:low,medium,high',
            'stop_copy_loss' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $user = Auth::user();
        $settings = CopyTradingSetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'source_account' => $request->source_account,
                'capital_percentage' => $request->capital_percentage,
                'risk_level' => $request->risk_level,
                'stop_copy_loss' => $request->stop_copy_loss,
                'is_active' => $request->boolean('is_active'),
            ]
        );

        return redirect()->route('site.copy-trading.index')
            ->with('success', 'تم حفظ إعدادات النسخ بنجاح.');
    }
}
