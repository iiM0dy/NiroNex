<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionRequestType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Http\Controllers\Controller;
use App\Models\RobotSetting;
use App\Models\Transaction;
use App\Models\TransactionRequest;
use App\Models\Wallet;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTransactionRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = TransactionRequest::query()
            ->whereHas('user', fn ($q) => $q->realUsers());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('created_at', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
                    });
            });
        }

        $requests = $query->latest()->paginate(10);
        return view('admin.transactions-requests.index', compact('requests'));
    }

    public function robotRequests(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'pending');

        $baseQuery = TransactionRequest::with(['user', 'reviewer', 'robotSetting'])
            ->where('type', TransactionRequestType::Robot)
            ->whereHas('user', fn ($q) => $q->realUsers());

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', TransactionStatus::Pending)->count(),
            'accepted' => (clone $baseQuery)->where('status', TransactionStatus::Accepted)->count(),
            'rejected' => (clone $baseQuery)->where('status', TransactionStatus::Rejected)->count(),
            'canceled' => (clone $baseQuery)->where('status', TransactionStatus::Canceled)->count(),
        ];

        $query = clone $baseQuery;

        if (in_array($status, ['pending', 'accepted', 'rejected', 'canceled'], true)) {
            $query->where('status', match ($status) {
                'accepted' => TransactionStatus::Accepted,
                'rejected' => TransactionStatus::Rejected,
                'canceled' => TransactionStatus::Canceled,
                default => TransactionStatus::Pending,
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
                    });
            });
        }

        $requests = $query->latest()->paginate(12);

        return view('admin.robot-requests.index', compact('requests', 'stats', 'status'));
    }

    public function reject($id, Request $request)
    {
        $transactionRequest = TransactionRequest::whereHas('user', fn ($q) => $q->realUsers())->findOrFail($id);

        if ($transactionRequest->status !== TransactionStatus::Pending) {
            return redirect()->back()->with('error', 'تمت مراجعة هذا الطلب مسبقًا.');
        }

        if ($transactionRequest->type === TransactionRequestType::Robot) {
            DB::transaction(function () use ($transactionRequest, $request) {
                $transactionRequest->update([
                    'status' => TransactionStatus::Rejected,
                    'reviewed_by' => auth()->id(),
                    'admin_note' => $request->admin_note,
                ]);

                $setting = RobotSetting::where('transaction_request_id', $transactionRequest->id)
                    ->lockForUpdate()
                    ->first();

                if (!$setting) {
                    return;
                }

                if (!$setting->refund_transaction_id && $setting->allocation_amount > 0) {
                    $depositWallet = $transactionRequest->user
                        ->wallets()
                        ->where('type', WalletType::Deposit)
                        ->lockForUpdate()
                        ->first();

                    if (!$depositWallet) {
                        $depositWallet = Wallet::create([
                            'user_id' => $transactionRequest->user_id,
                            'type' => WalletType::Deposit,
                            'balance' => 0,
                        ]);
                    }

                    $refundTransaction = Transaction::create([
                        'wallet_id' => $depositWallet->id,
                        'transaction_request_id' => $transactionRequest->id,
                        'type' => TransactionType::RobotRefund->value,
                        'status' => TransactionStatus::Accepted->value,
                        'amount' => $setting->allocation_amount,
                        'description' => 'استرجاع مبلغ تخصيص الروبوت بعد الرفض',
                        'transaction_date' => now(),
                    ]);

                    $setting->refund_transaction_id = $refundTransaction->id;
                }

                $setting->status = TransactionStatus::Rejected;
                $setting->is_active = false;
                $setting->save();
            });

            return back()->with('success', 'تم رفض طلب الروبوت وإرجاع مبلغ التخصيص إلى محفظة المستخدم.');
        }

        $transactionRequest->update([
            'status' => TransactionStatus::Rejected,
            'reviewed_by' => auth()->id(),
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'تم رفض الطلب بنجاح.');
    }

    public function approve($id, Request $request)
    {
        $transactionRequest = TransactionRequest::whereHas('user', fn ($q) => $q->realUsers())->findOrFail($id);

        if ($transactionRequest->status !== TransactionStatus::Pending) {
            return redirect()->back()->with('error', 'تمت مراجعة هذا الطلب مسبقًا.');
        }

        if ($transactionRequest->type === TransactionRequestType::Robot) {
            DB::transaction(function () use ($transactionRequest, $request) {
                $transactionRequest->update([
                    'status' => TransactionStatus::Accepted,
                    'admin_note' => $request->admin_note,
                    'reviewed_by' => auth()->id(),
                ]);

                RobotSetting::where('transaction_request_id', $transactionRequest->id)
                    ->lockForUpdate()
                    ->each(function (RobotSetting $setting) {
                        $setting->status = TransactionStatus::Accepted;
                        $setting->is_active = true;
                        $setting->save();
                    });
            });

            return back()->with('success', 'تمت الموافقة على طلب الروبوت وتفعيل الإعدادات بنجاح.');
        }

        DB::transaction(function () use ($transactionRequest, $request) {
            $transactionRequest->update([
                'status' => TransactionStatus::Accepted,
                'admin_note' => $request->admin_note,
                'reviewed_by' => auth()->id(),
            ]);

            $user = $transactionRequest->user;
            $amount = $transactionRequest->amount;

            if ($transactionRequest->type === TransactionRequestType::InternalTransfer) {

                $receiver = $transactionRequest->receiver;
                if (!$receiver) {
                    throw new \Exception('المستلم غير موجود لطلب التحويل الداخلي.');
                }

                $fromWalletType = $transactionRequest->transfer_data['from_wallet_type'] ?? WalletType::Deposit->value;

                $senderWallet = $user->wallets()->where('type', $fromWalletType)->lockForUpdate()->first();
                if (!$senderWallet) {
                    throw new \Exception('محفظة المرسل غير موجودة.');
                }
                if ($senderWallet->balance < $amount) {
                    throw new \Exception('رصيد المحفظة غير كافٍ.');
                }

                $receiverWallet = $receiver->wallets()->where('type', WalletType::Deposit)->lockForUpdate()->first();
                if (!$receiverWallet) {
                    $receiverWallet = Wallet::create([
                        'user_id' => $receiver->id,
                        'type' => WalletType::Deposit,
                        'balance' => 0,
                    ]);
                }

                Transaction::create([
                    'wallet_id' => $senderWallet->id,
                    'transaction_request_id' => $transactionRequest->id,
                    'type' => TransactionType::Withdrawal,
                    'status' => TransactionStatus::Accepted,
                    'amount' => $amount,
                    'description' => 'تحويل داخلي إلى ' . $receiver->full_name,
                    'transaction_date' => now(),
                ]);

                Transaction::create([
                    'wallet_id' => $receiverWallet->id,
                    'transaction_request_id' => $transactionRequest->id,
                    'type' => TransactionType::Deposit,
                    'status' => TransactionStatus::Accepted,
                    'amount' => $amount,
                    'description' => 'تحويل داخلي من ' . $user->full_name,
                    'transaction_date' => now(),
                ]);

            } else {

                $walletType = null;
                match ($transactionRequest->type) {
                    TransactionRequestType::Deposit => $walletType = WalletType::Deposit,
                    TransactionRequestType::Withdrawal => $walletType = WalletType::Profit,
                    TransactionRequestType::InternalTransfer => $walletType = WalletType::Profit,
                };

                $wallet = $user->wallets()->where('type', $walletType)->lockForUpdate()->first();
                if (!$wallet) {
                    $wallet = $user->wallets()->create([
                        'type' => $walletType,
                        'balance' => 0,
                    ]);
                }

                $transactionType = match ($transactionRequest->type) {
                    TransactionRequestType::Deposit => TransactionType::Deposit,
                    TransactionRequestType::Withdrawal => TransactionType::Withdrawal,
                    default => throw new \Exception('نوع الطلب غير معروف.'),
                };

                Transaction::create([
                    'wallet_id' => $wallet->id,
                    'transaction_request_id' => $transactionRequest->id,
                    'type' => $transactionType,
                    'status' => TransactionStatus::Accepted,
                    'amount' => $amount,
                    'description' => ($transactionRequest->type === TransactionRequestType::Deposit ? 'إيداع' : 'سحب') . ' عن طريق ' . ($transactionRequest->method?->getName() ?? ''),
                    'transaction_date' => now(),
                ]);
            }
        });

        return back()->with('success', 'تمت الموافقة على الطلب وتم تحديث المحفظات بنجاح.');
    }

    public function internalTransfer(Request $request)
    {
        $search = $request->get('search');

        $query = TransactionRequest::query()
            ->where('type', TransactionRequestType::InternalTransfer)
            ->whereHas('user', fn ($q) => $q->realUsers())
            ->whereHas('receiver', fn ($q) => $q->realUsers());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('created_at', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(10);

        return view('admin.transactions-requests.internal-transfer', compact('requests'));
    }

    public function createInternalTransfer()
    {
        $wallets = Wallet::whereHas('user', fn ($q) => $q->realUsers())->get();
        return view('admin.transactions-requests.create-internal-transfer', compact('wallets'));
    }

    public function storeInternalTransfer(Request $request)
    {
        $request->validate([
            'to_id' => [
                'required',
                'exists:wallets,id',
                Rule::notIn([$request->from_id]),
            ],
            'from_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
        ], [
            'to_id.not_in' => 'لا يمكن التحويل إلى نفس المحفظة.',
        ]);
        try {
            $fromWallet = Wallet::whereHas('user', fn ($q) => $q->realUsers())->find($request->from_id);
            $toWallet = Wallet::whereHas('user', fn ($q) => $q->realUsers())->find($request->to_id);

            if (!$fromWallet) {
                throw new \Exception('محفظة المرسل غير موجودة.');
            }
            if (!$toWallet) {
                throw new \Exception('محفظة المستقبل غير موجودة.');
            }
            if ($fromWallet->balance < $request->amount) {
                throw new \Exception('رصيد المحفظة غير كافٍ.');
            }

            DB::beginTransaction();
            $transactionRequest = TransactionRequest::create([
                'user_id' => $fromWallet->user->id,
                'receiver_id' => $toWallet->user->id,
                'type' => TransactionRequestType::InternalTransfer,
                'method' => null,
                'amount' => $request->amount,
                'note' => "تحويل داخلي بواسطة المدير",
                'status' => TransactionStatus::Accepted,
            ]);

            Transaction::create([
                'wallet_id' => $fromWallet->id,
                'transaction_request_id' => $transactionRequest->id,
                'type' => TransactionType::Withdrawal,
                'status' => TransactionStatus::Accepted,
                'amount' => $request->amount,
                'description' => 'تحويل داخلي إلى ' . $toWallet->user->full_name,
                'transaction_date' => now(),
            ]);

            Transaction::create([
                'wallet_id' => $toWallet->id,
                'transaction_request_id' => $transactionRequest->id,
                'type' => TransactionType::Deposit,
                'status' => TransactionStatus::Accepted,
                'amount' => $request->amount,
                'description' => 'تحويل داخلي من ' . $fromWallet->user->full_name,
                'transaction_date' => now(),
            ]);
            DB::commit();
            return back()->with('success', 'تم انشاء الطلب وتم تحديث المحفظات بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $transactionRequest = TransactionRequest::whereHas('user', fn ($q) => $q->realUsers())->findOrFail($id);

        if ($transactionRequest->status == TransactionStatus::Accepted) {
            return redirect()->back()->with('error', 'لا يمكن حذف طلب مقبول');
        }

        $transactionRequest->delete();

        return back()->with('success', 'تم حذف الطلب بنجاح.');
    }

}
