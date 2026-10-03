<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ar_SA');

        // Create Plans if none exist
        if (\App\Models\Plan::count() == 0) {
            $plans = [];
            for ($i = 1; $i <= 4; $i++) {
                $plans[] = \App\Models\Plan::create([
                    'name' => 'خطة NiroNex ' . $i,
                    'profit_rate' => 1.5,
                    'min_deposit' => 10,
                    'max_deposit' => 5000,
                    'duration_days' => 30,
                    'description' => 'خطة مميزة بعائد يومي مستقر ونسبة مخاطرة منخفضة.'
                ]);
            }
        } else {
            $plans = \App\Models\Plan::all();
        }

        // Create 20 Users
        $users = [];
        for ($i = 0; $i < 20; $i++) {
            $plan = $plans->random();
            $createdAt = \Carbon\Carbon::now()->subDays(rand(1, 45));
            $user = \App\Models\User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'phone' => '05' . rand(0, 9) . rand(1000000, 9999999),
                'birthday' => \Carbon\Carbon::now()->subYears(rand(20, 50)),
                'type' => \App\Enums\UserType::User,
                'status' => \App\Enums\UserStatus::Active,
                'plan_id' => $plan->id,
                'email_verified_at' => now(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Wallets
            $depositWallet = \App\Models\Wallet::create([
                'user_id' => $user->id,
                'type' => \App\Enums\WalletType::Deposit,
                'balance' => rand(100, 10000),
            ]);
            $profitWallet = \App\Models\Wallet::create([
                'user_id' => $user->id,
                'type' => \App\Enums\WalletType::Profit,
                'balance' => rand(50, 2000),
            ]);

            $users[] = $user;
        }

        // Create Transactions and Requests
        foreach ($users as $user) {
            $wDep = $user->wallets()->where('type', \App\Enums\WalletType::Deposit)->first();
            $wPro = $user->wallets()->where('type', \App\Enums\WalletType::Profit)->first();

            // Create 3-8 transactions per user
            $txCount = rand(3, 8);
            for ($j = 0; $j < $txCount; $j++) {
                $type = $faker->randomElement([\App\Enums\TransactionType::Deposit, \App\Enums\TransactionType::Withdrawal, \App\Enums\TransactionType::Profit]);

                $walletId = ($type === \App\Enums\TransactionType::Profit) ? $wPro->id : $wDep->id;
                $status = $faker->randomElement([\App\Enums\TransactionStatus::Accepted, \App\Enums\TransactionStatus::Pending, \App\Enums\TransactionStatus::Rejected]);
                if ($type === \App\Enums\TransactionType::Profit)
                    $status = \App\Enums\TransactionStatus::Accepted; // Profits always accepted

                $amount = ($type === \App\Enums\TransactionType::Profit) ? rand(5, 50) : rand(100, 5000);
                $txDate = clone $user->created_at;
                $txDate->addDays(rand(1, 30));

                $req = null;
                // If deposit/withdrawal create a request too
                if ($type !== \App\Enums\TransactionType::Profit) {
                    $reqType = ($type === \App\Enums\TransactionType::Deposit) ? \App\Enums\TransactionRequestType::Deposit : \App\Enums\TransactionRequestType::Withdrawal;
                    $req = \App\Models\TransactionRequest::create([
                        'user_id' => $user->id,
                        'type' => $reqType,
                        'method' => \App\Enums\TransactionRequestMethod::USDT_TRC20,
                        'amount' => $amount,
                        'status' => $status,
                        'created_at' => $txDate,
                        'updated_at' => $txDate,
                    ]);
                }

                \App\Models\Transaction::create([
                    'wallet_id' => $walletId,
                    'transaction_request_id' => $req ? $req->id : null,
                    'type' => $type,
                    'status' => $status,
                    'amount' => $amount,
                    'description' => $type->getName() . ' تم بواسطة: ' . $user->full_name,
                    'transaction_date' => $txDate,
                    'created_at' => $txDate,
                    'updated_at' => $txDate,
                ]);
            }
        }

        // Setup some random Referrals
        for ($i = 0; $i < 5; $i++) {
            $referrer = \Illuminate\Support\Arr::random($users);
            $referred = \Illuminate\Support\Arr::random($users);
            if ($referrer->id != $referred->id) {
                // Earn something from them
                \App\Models\ReferralEarning::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $referred->id,
                    'amount' => rand(10, 100),
                    'created_at' => now()->subDays(rand(1, 15)),
                ]);
            }
        }
    }
}
