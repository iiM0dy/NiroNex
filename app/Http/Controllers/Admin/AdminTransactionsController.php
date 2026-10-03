<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class AdminTransactionsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Transaction::query()
            ->whereHas('wallet.user', fn ($q) => $q->realUsers());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('created_at', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', new Enum(TransactionType::class)],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
            'transaction_date' => ['required'],
        ]);
        try {
            $walletId = Wallet::where('user_id', $request->user_id)
                ->whereHas('user', fn ($q) => $q->realUsers())
                ->where('type', WalletType::Profit->value)
                ->firstOrFail()
                ->id;
            $desc = $request->type == TransactionType::Profit->value ? 'أرباح خطة الاشتراك' : 'أرباح نسبة احالة';
            Transaction::create([
                'wallet_id' => $walletId,
                'type' => $request->type,
                'status' => TransactionStatus::Accepted,
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
                'description' => $desc,
            ]);
            return redirect()->back()->with('success', 'تم اضافة المعاملة بنجاح.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);
        try {
            $tran = Transaction::whereHas('wallet.user', fn ($q) => $q->realUsers())->find($id);
            if (!$tran) {
                return redirect()->back()->with('error', 'لم يتم العثور على الدفعة.');
            }
            if ($tran->type != TransactionType::Deposit) {
                return redirect()->back()->with('error', 'يمكنك فقط التعديل على معاملات الايداع.');
            }

            DB::beginTransaction();
            $tran->update(['amount' => $request->amount]);
            $tran->transactionRequest()->update(['amount' => $request->amount]);
            DB::commit();

            return redirect()->back()->with('success', 'تم تحديث المعاملة بنجاح.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
