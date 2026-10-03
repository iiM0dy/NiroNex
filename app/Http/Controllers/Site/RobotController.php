<?php

namespace App\Http\Controllers\Site;

use App\Enums\TransactionRequestType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\RobotSetting;
use App\Models\Transaction;
use App\Models\TransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RobotController extends Controller
{
    private const PEP_PRICES = [
        'low' => 0.10,
        'medium' => 1.00,
        'high' => 10.00,
    ];

    private const RISK_RULES = [
        'low' => [
            'min_allocation' => 20,
            'default_take_profit' => 30,
            'min_take_profit' => 0.01,
            'default_stop_loss' => 15,
            'min_stop_loss' => 0.01,
            'auto_stop_loss_half' => true,
            'fixed_values' => false,
        ],
        'medium' => [
            'min_allocation' => 100,
            'default_take_profit' => 50,
            'min_take_profit' => 50,
            'default_stop_loss' => 25,
            'min_stop_loss' => 25,
            'auto_stop_loss_half' => false,
            'fixed_values' => false,
        ],
        'high' => [
            'min_allocation' => 300,
            'default_take_profit' => 90,
            'min_take_profit' => 90,
            'default_stop_loss' => 30,
            'min_stop_loss' => 30,
            'auto_stop_loss_half' => false,
            'fixed_values' => true,
        ],
    ];

    public function index()
    {
        $user = Auth::user();
        $settings = $user->robotSetting ?? new RobotSetting([
            'risk_level' => 'low',
            'wallet_percentage' => 0,
            'take_profit' => self::RISK_RULES['low']['default_take_profit'],
            'stop_loss' => self::RISK_RULES['low']['default_stop_loss'],
            'pep_price' => self::PEP_PRICES['low'],
            'allocation_amount' => self::RISK_RULES['low']['min_allocation'],
        ]);

        $availableBalance = (float) ($user->depositWallet?->balance ?? 0);
        $status = $settings->status;
        $formLocked = $settings->exists && in_array($status, [TransactionStatus::Pending, TransactionStatus::Accepted], true);

        return view('site.robot', [
            'user' => $user,
            'settings' => $settings,
            'availableBalance' => $availableBalance,
            'pepPrices' => self::PEP_PRICES,
            'riskRules' => self::RISK_RULES,
            'formLocked' => $formLocked,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'risk_level' => 'required|in:low,medium,high',
            'allocation_amount' => 'required|numeric|min:0.01',
            'take_profit' => 'required|numeric|min:0.01|max:100',
            'stop_loss' => 'required|numeric|min:0.01|max:100',
        ], [
            'allocation_amount.required' => 'يرجى إدخال المبلغ المستخدم من محفظة الإيداع.',
            'allocation_amount.min' => 'المبلغ المستخدم يجب أن يكون أكبر من صفر.',
            'take_profit.required' => 'يرجى إدخال نسبة جني الربح.',
            'take_profit.max' => 'نسبة جني الربح يجب أن تكون 100% أو أقل.',
            'stop_loss.required' => 'يرجى إدخال نسبة وقف الخسارة.',
            'stop_loss.max' => 'نسبة وقف الخسارة يجب أن تكون 100% أو أقل.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user?->isDemoAccount()) {
            return redirect()
                ->route('site.robot.index')
                ->with('warning', 'حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لاستخدام هذه الميزة.');
        }

        $existingSetting = $user->robotSetting;

        if ($existingSetting && in_array($existingSetting->status, [TransactionStatus::Pending, TransactionStatus::Accepted], true)) {
            $message = $existingSetting->status === TransactionStatus::Pending
                ? 'يوجد طلب روبوت قيد المراجعة بالفعل. انتظر قرار الإدارة قبل إرسال طلب جديد.'
                : 'تم تفعيل الروبوت لهذا الحساب بالفعل. راجع الإدارة قبل طلب تعديل جديد.';

            return redirect()
                ->route('site.robot.index')
                ->with('error', $message);
        }

        $availableBalance = (float) ($user->depositWallet?->balance ?? 0);

        if ($availableBalance <= 0) {
            return redirect()
                ->route('site.robot.index')
                ->with('error', 'لا يوجد رصيد متاح في محفظة الإيداع لتخصيصه للروبوت.');
        }

        $riskRules = self::RISK_RULES[$validated['risk_level']];
        $minAllocation = (float) $riskRules['min_allocation'];

        if ((float) $validated['allocation_amount'] < $minAllocation) {
            return redirect()
                ->route('site.robot.index')
                ->withErrors(['allocation_amount' => 'أقل مبلغ لهذا المستوى هو ' . formatCurrency($minAllocation) . '.'])
                ->withInput();
        }

        if ($riskRules['fixed_values']) {
            $validated['take_profit'] = (float) $riskRules['default_take_profit'];
            $validated['stop_loss'] = (float) $riskRules['default_stop_loss'];
        }

        if (! $riskRules['fixed_values'] && (float) $validated['take_profit'] < (float) $riskRules['min_take_profit']) {
            return redirect()
                ->route('site.robot.index')
                ->withErrors(['take_profit' => 'أقل نسبة جني ربح لهذا المستوى هي ' . formatPercent($riskRules['min_take_profit'], 2) . '.'])
                ->withInput();
        }

        if (! $riskRules['fixed_values'] && ! $riskRules['auto_stop_loss_half'] && (float) $validated['stop_loss'] < (float) $riskRules['min_stop_loss']) {
            return redirect()
                ->route('site.robot.index')
                ->withErrors(['stop_loss' => 'أقل حد خسارة لهذا المستوى هو ' . formatPercent($riskRules['min_stop_loss'], 2) . '.'])
                ->withInput();
        }

        if (! $riskRules['fixed_values'] && $riskRules['auto_stop_loss_half']) {
            $validated['stop_loss'] = round((float) $validated['take_profit'] / 2, 2);
        }

        $pepPrice = self::PEP_PRICES[$validated['risk_level']];
        $riskLabel = $this->riskLabel($validated['risk_level']);

        try {
            DB::transaction(function () use ($user, $validated, $pepPrice, $riskLabel, $existingSetting) {
                $depositWallet = $user->depositWallet()->lockForUpdate()->first();

                if (!$depositWallet || (float) $depositWallet->balance <= 0) {
                    throw new \RuntimeException('لا يوجد رصيد متاح في محفظة الإيداع لتخصيصه للروبوت.');
                }

                $allocationAmount = round((float) $validated['allocation_amount'], 6);

                if ($allocationAmount <= 0) {
                    throw new \RuntimeException('المبلغ المستخدم غير صالح.');
                }

                if ($allocationAmount > (float) $depositWallet->balance) {
                    throw new \RuntimeException('المبلغ المستخدم لا يمكن أن يتجاوز رصيد محفظة الإيداع المتاح.');
                }

                $walletPercentage = round(($allocationAmount / (float) $depositWallet->balance) * 100, 2);

                $requestPayload = [
                    'risk_level' => $validated['risk_level'],
                    'risk_level_label' => $riskLabel,
                    'wallet_percentage' => $walletPercentage,
                    'allocation_amount' => $allocationAmount,
                    'pep_price' => $pepPrice,
                    'take_profit' => (float) $validated['take_profit'],
                    'stop_loss' => (float) $validated['stop_loss'],
                ];

                $robotRequest = TransactionRequest::create([
                    'user_id' => $user->id,
                    'type' => TransactionRequestType::Robot->value,
                    'method' => null,
                    'amount' => $allocationAmount,
                    'status' => TransactionStatus::Pending->value,
                    'note' => 'طلب تفعيل إعدادات الروبوت',
                    'transfer_data' => $requestPayload,
                ]);

                $allocationTransaction = Transaction::create([
                    'wallet_id' => $depositWallet->id,
                    'transaction_request_id' => $robotRequest->id,
                    'type' => TransactionType::RobotAllocation->value,
                    'status' => TransactionStatus::Accepted->value,
                    'amount' => $allocationAmount,
                    'description' => 'تخصيص رصيد لطلب تفعيل الروبوت',
                    'transaction_date' => now(),
                ]);

                RobotSetting::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'risk_level' => $validated['risk_level'],
                        'take_profit' => $validated['take_profit'],
                        'stop_loss' => $validated['stop_loss'],
                        'trade_duration' => $existingSetting?->trade_duration ?? 'weekly',
                        'wallet_percentage' => $walletPercentage,
                        'pep_price' => $pepPrice,
                        'allocation_amount' => $allocationAmount,
                        'status' => TransactionStatus::Pending->value,
                        'transaction_request_id' => $robotRequest->id,
                        'allocation_transaction_id' => $allocationTransaction->id,
                        'refund_transaction_id' => null,
                        'is_active' => false,
                    ]
                );
            });
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('site.robot.index')
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('site.robot.index')
            ->with('success', 'تم إرسال طلب الروبوت إلى الإدارة وحجز المبلغ المخصص بنجاح.');
    }

    private function riskLabel(string $riskLevel): string
    {
        return match ($riskLevel) {
            'low' => 'منخفض',
            'medium' => 'متوسط',
            'high' => 'مرتفع',
            default => $riskLevel,
        };
    }
}
