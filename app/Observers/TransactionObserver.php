<?php

namespace App\Observers;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Models\ReferralEarning;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        if (
            $transaction->isDirty('status') ||
            $transaction->status === TransactionStatus::Accepted
        ) {
            try {
                $wallet = $transaction->wallet()->lockForUpdate()->firstOrFail();
                if (!$wallet) {
                    if ($transaction->type == TransactionType::Deposit) {
                        $wallet = $transaction->wallet()->create([
                            'user_id' => $transaction->wallet->user_id,
                            'type' => WalletType::Deposit,
                            'balance' => 0,
                        ]);
                    } else {
                        $wallet = $transaction->wallet()->create([
                            'user_id' => $transaction->wallet->user_id,
                            'type' => WalletType::Profit,
                            'balance' => 0,
                        ]);
                    }
                }
                match ($transaction->type) {
                    TransactionType::Deposit => $wallet->balance += $transaction->amount,
                    TransactionType::Withdrawal => $wallet->balance -= $transaction->amount,
                    TransactionType::Profit => $wallet->balance += $transaction->amount,
                    TransactionType::ProfitRefer => $wallet->balance += $transaction->amount,
                    TransactionType::RobotAllocation => $wallet->balance -= $transaction->amount,
                    TransactionType::RobotRefund => $wallet->balance += $transaction->amount,
                    TransactionType::InternalTransfer => $wallet->balance -= $transaction->amount, // Decrement wallet when moving to trading
                    TransactionType::PlanSubscription => $wallet->balance -= $transaction->amount,
                    default => null,
                };

                $wallet->save();

                \Log::info("Wallet balance updated for wallet ID {$wallet->id} due to transaction ID {$transaction->id}");

            } catch (\Exception $e) {
                \Log::error("Error updating wallet balance for transaction ID {$transaction->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        if ($transaction->wasChanged('amount') && $transaction->status === TransactionStatus::Accepted) {
            try {
                $wallet = $transaction->wallet()->lockForUpdate()->first();

                if ($wallet) {
                    $originalAmount = $transaction->getOriginal('amount');
                    $newAmount = $transaction->amount;
                    $diff = $newAmount - $originalAmount;

                    match ($transaction->type) {
                        TransactionType::Deposit,
                        TransactionType::Profit,
                        TransactionType::RobotRefund => $wallet->balance += $diff,
                        TransactionType::Withdrawal,
                        TransactionType::RobotAllocation,
                        TransactionType::InternalTransfer,
                        TransactionType::PlanSubscription => $wallet->balance -= $diff,
                        default => null,
                    };

                    $wallet->save();

                    \Log::info("Wallet updated on transaction update. Wallet ID: {$wallet->id}, Difference: $diff");
                }
            } catch (\Exception $e) {
                \Log::error("Error updating wallet balance on transaction update. Transaction ID: {$transaction->id}: " . $e->getMessage());
            }
        }
    }



    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
