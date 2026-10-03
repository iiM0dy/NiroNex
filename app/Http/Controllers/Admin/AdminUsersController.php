<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\WalletType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = User::realUsers();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function verificationKyc(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'pending');

        $baseQuery = User::realUsers();

        $submittedQuery = (clone $baseQuery)->where(function ($q) {
            $q->whereNotNull('id_photo_front')
                ->orWhereNotNull('id_photo_back')
                ->orWhereNotNull('selfie_photo');
        });

        $stats = [
            'total' => (clone $submittedQuery)->count(),
            'pending' => (clone $submittedQuery)->where('status', UserStatus::Pending)->count(),
            'active' => (clone $submittedQuery)->where('status', UserStatus::Active)->count(),
            'inactive' => (clone $submittedQuery)->where('status', UserStatus::Inactive)->count(),
            'missing_docs' => (clone $baseQuery)->where(function ($q) {
                $q->whereNull('id_photo_front')
                    ->orWhereNull('id_photo_back')
                    ->orWhereNull('selfie_photo');
            })->count(),
        ];

        $query = $status === 'missing_docs' ? clone $baseQuery : clone $submittedQuery;

        if ($status === 'missing_docs') {
            $query->where(function ($q) {
                $q->whereNull('id_photo_front')
                    ->orWhereNull('id_photo_back')
                    ->orWhereNull('selfie_photo');
            });
        } elseif (in_array($status, ['pending', 'active', 'inactive'], true)) {
            $query->where('status', match ($status) {
                'active' => UserStatus::Active,
                'inactive' => UserStatus::Inactive,
                default => UserStatus::Pending,
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(12);

        return view('admin.verification-kyc.index', compact('users', 'stats', 'status'));
    }

    public function show($id)
    {
        $user = User::realUsers()->with([
            'plan',
            'requests.receiver',
            'wallets.transactions.transactionRequest',
            'robotSettings',
            'referrer',
            'referrals',
            'referralEarnings',
        ])->findOrFail($id);
        $transactions = $user->wallets->flatMap->transactions->map(function ($trx) {
            return [
                'id' => $trx->id,
                'display_id' => '#' . str_pad($trx->id, 4, '0', STR_PAD_LEFT),
                'type' => $trx->type->getName(),
                'amount' => formatCurrency($trx->amount),
                'status' => renderStatusBadge($trx->status),
                'date' => formatDate($trx->transaction_date) ?? '',
                'description' => $trx->description,
            ];
        })->reverse()->values();
        $requests = $user->requests()->latest()->get()->map(function ($req) {
            return [
                'id' => $req->id,
                'display_id' => '#' . str_pad($req->id, 4, '0', STR_PAD_LEFT),
                'type' => $req->type->getName(),
                'receiver' => optional($req->receiver)->full_name ?? '—',
                'method' => $req->method ? $req->method->getName() : "---",
                'amount' => formatCurrency($req->amount),
                'status' => renderStatusBadge($req->status),
                'image' => $req->getStorageUrl($req->image) ?? null,
                'created_at' => formatDate($req->created_at),
            ];
        });
        return view('admin.users.show', compact('user', 'requests', 'transactions'));
    }

    public function approveKyc($id)
    {
        $user = User::realUsers()->findOrFail($id);
        $user->status = UserStatus::Active;
        $user->save();

        return redirect()->back()->with('success', 'تمت الموافقة على وثائق التحقق بنجاح');
    }

    public function rejectKyc($id)
    {
        $user = User::realUsers()->findOrFail($id);
        $user->status = UserStatus::Inactive;
        $user->save();

        return redirect()->back()->with('success', 'تم رفض وثائق التحقق وتحديث حالة الحساب');
    }

    public function destroy($id)
    {
        $user = User::realUsers()->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', new Enum(UserStatus::class)],
        ]);

        $user = User::realUsers()->findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث حالة المستخدم بنجاح');
    }

    public function updateDepositWallet(Request $request, $userId)
    {
        $request->validate([
            'value' => ['required', 'numeric', 'min:0'],
        ]);
        $user = User::realUsers()->findOrFail($userId);
        $wallet = $user->depositWallet;

        if (!$wallet) {
            $wallet = $user->wallets()->create([
                'type' => WalletType::Deposit,
                'balance' => 0,
            ]);
        }

        $wallet->balance = $request->value;
        $wallet->save();

        return redirect()->back()->with('success', 'تم تعديل رصيد محفظة الإيداع بنجاح');
    }
}
