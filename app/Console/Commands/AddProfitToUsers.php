<?php

namespace App\Console\Commands;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\UserStatus;
use App\Enums\WalletType;
use App\Models\ReferralEarning;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Log;

class AddProfitToUsers extends Command
{
    protected $signature = 'profit:add-to-users';
    protected $description = 'Add profit to users wallets based on their plans';

    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        parent::__construct();
        $this->walletService = $walletService;
    }

    public function handle()
    {
        $now = Carbon::now();
        $users = User::realUsers()
            ->whereNotNull('plan_id')
            ->where('status', UserStatus::Active)
            ->get();

        foreach ($users as $user) {
            $plan = $user->plan;

            if (!$plan || $plan->isRobotPlan() || !$user->last_profit_date) {
                continue;
            }

            $lastProfit = Carbon::parse($user->last_profit_date);
            $durationDays = $plan->duration_days ?? 1;

            // Skip if profit period not reached yet
            if ($lastProfit->diffInDays($now) < $durationDays) {
                continue;
            }

            $profitRatePercent = $plan->profit_rate;
            $profitRate = $profitRatePercent / 100;

            $profitWallet = $user->profitWallet;
            $planAmount = (float) $user->plan_amount;

            if (!$profitWallet) {
                $profitWallet = Wallet::create([
                    'user_id' => $user->id,
                    'type' => WalletType::Profit,
                    'balance' => 0,
                ]);
            }

            if ($planAmount <= 0) {
                $this->info("User {$user->full_name} has no active plan principal.");
                continue;
            }

            $profitAmount = round($planAmount * $profitRate, 2);
            if ($profitAmount <= 0) {
                $this->info("User ID {$user->id} profit amount calculated zero.");
                Log::channel('profits')->info("Calculated profit zero", [
                    'user_id' => $user->id,
                    'user_name' => $user->full_name,
                ]);
                continue;
            }

            $retries = 3;
            $success = false;

            for ($i = 0; $i < $retries; $i++) {
                try {
                    DB::transaction(function () use ($profitWallet, $user, $profitAmount, $now, &$success) {
                        // Add profit to wallet
                        $success = $this->walletService->addProfit($profitWallet, $profitAmount, 'أرباح خطة الاشتراك');

                        if (!$success) {
                            throw new \Exception("addProfit returned false");
                        }

                        // Save last profit date
                        $user->last_profit_date = $now;
                        $user->save();

                        // Log successful profit addition
                        Log::channel('profits')->info("Profit added", [
                            'user_id' => $user->id,
                            'user_name' => $user->full_name,
                            'plan_id' => $user->plan_id,
                            'plan_amount' => $user->plan_amount,
                            'amount' => $profitAmount,
                            'date' => $now->toDateTimeString(),
                        ]);

                        if ($user->referrer_id) {
                            $referrer = $user->referrer;
                            $commission = round($profitAmount * env('REFER_PERCENT', 0.03), 4);
                            if ($commission > 0) {
                                $refWallet = $referrer->profitWallet()->first();

                                $t = $refWallet->transactions()->create([
                                    'type' => TransactionType::ProfitRefer,
                                    'amount' => $commission,
                                    'status' => TransactionStatus::Accepted,
                                    'description' => "نسبة إحالة من أرباح {$user->full_name}",
                                ]);

                                ReferralEarning::create([
                                    'referrer_id' => $referrer->id,
                                    'referred_id' => $user->id,
                                    'transaction_id' => $t->id,
                                    'amount' => $commission,
                                ]);

                                Log::info("Referral daily commission of $commission added to referrer ID {$referrer->id} from user ID {$user->id}");
                            }
                        }
                    });
                    $this->info("Profit of {$profitAmount} added to User {$user->full_name}");

                    $success = true;
                    break;
                } catch (\Throwable $e) {
                    Log::channel('profits')->error("Profit distribution failed", [
                        'user_id' => $user->id,
                        'user_name' => $user->full_name,
                        'plan_id' => $user->plan_id,
                        'plan_amount' => $user->plan_amount,
                        'amount' => $profitAmount,
                        'error' => $e->getMessage(),
                        'attempt' => $i + 1,
                    ]);

                    if ($i < $retries - 1) {
                        sleep(1); // Small delay before retry
                    }
                }
            }


            if (!$success) {
                $this->error("Final failure after {$retries} attempts for User {$user->full_name}");
            }
        }

        $this->info('Profit addition process completed.');
        return 0;
    }
}
