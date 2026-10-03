<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Plan;
use App\Models\Trade;
use App\Models\Transaction;
use App\Models\TransactionRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\TransactionRequestType;
use App\Enums\TransactionRequestMethod;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Enums\WalletType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get Planet (Trader is one from PlanSeeder)
        $plan = Plan::where('name', 'Trader')->first();

        // 2. Create Normal User
        $user = User::updateOrCreate(
            ['email' => 'demo@nironex.com'],
            [
                'first_name' => 'صقر',
                'last_name' => 'NiroNex',
                'password' => Hash::make('password'),
                'phone' => '0501234567',
                'status' => UserStatus::Active,
                'type' => UserType::User,
                'is_demo' => true,
                'email_verified_at' => now(),
                'plan_id' => $plan ? $plan->id : null,
            ]
        );

        // 3. Ensure Wallets exist
        $depositWallet = Wallet::updateOrCreate(
            ['user_id' => $user->id, 'type' => WalletType::Deposit],
            ['balance' => 0]
        );

        $profitWallet = Wallet::updateOrCreate(
            ['user_id' => $user->id, 'type' => WalletType::Profit],
            ['balance' => 0]
        );

        // 4. Create History
        Transaction::whereIn('wallet_id', [$depositWallet->id, $profitWallet->id])->delete();

        // Initial Deposit
        Transaction::create([
            'wallet_id' => $depositWallet->id,
            'type' => TransactionType::Deposit,
            'status' => TransactionStatus::Accepted,
            'amount' => 1500.00,
            'description' => 'إيداع رصيد البداية',
            'transaction_date' => now()->subDays(30),
        ]);

        // Monthly Profits (15 entries)
        for ($i = 1; $i <= 15; $i++) {
            $date = now()->subDays(20 - $i);
            Transaction::create([
                'wallet_id' => $profitWallet->id,
                'type' => TransactionType::Profit,
                'status' => TransactionStatus::Accepted,
                'amount' => rand(1000, 5000) / 100,
                'description' => 'أرباح تداول AI يومية - نظام NiroNex',
                'transaction_date' => $date,
            ]);
        }

        // Recent Withdrawal (History)
        Transaction::create([
            'wallet_id' => $depositWallet->id,
            'type' => TransactionType::Withdrawal,
            'status' => TransactionStatus::Accepted,
            'amount' => 50.00,
            'description' => 'سحب رصيد لتجربة المنصة',
            'transaction_date' => now()->subDays(5),
        ]);

        // 5. Pending Request
        TransactionRequest::where('user_id', $user->id)->delete();
        TransactionRequest::create([
            'user_id' => $user->id,
            'type' => TransactionRequestType::Withdrawal,
            'method' => TransactionRequestMethod::USDT_TRC20,
            'amount' => 120.00,
            'status' => TransactionStatus::Pending,
        ]);

        // 6. Fake Trades
        Trade::where('user_id', $user->id)->delete();

        // Active
        Trade::create([
            'user_id' => $user->id,
            'ticket' => '#XAU-L' . rand(1000, 9999),
            'symbol' => 'XAUUSD',
            'type' => 'buy',
            'lot_size' => 0.25,
            'open_price' => 2035.40,
            'take_profit' => 2045.00,
            'stop_loss' => 2030.00,
            'pnl' => 85.50,
            'is_active' => true,
        ]);

        Trade::create([
            'user_id' => $user->id,
            'ticket' => '#XAU-L' . rand(1000, 9999),
            'symbol' => 'XAUUSD',
            'type' => 'sell',
            'lot_size' => 0.10,
            'open_price' => 2038.20,
            'take_profit' => 2030.00,
            'stop_loss' => 2045.00,
            'pnl' => -14.20,
            'is_active' => true,
        ]);

        // Closed History (10 items)
        for ($j = 0; $j < 10; $j++) {
            $type = rand(0, 1) ? 'buy' : 'sell';
            $isProfit = rand(0, 5) > 1; // 80% profit
            $pnl = $isProfit ? (rand(500, 2000) / 10) : (rand(-500, -100) / 10);
            
            Trade::create([
                'user_id' => $user->id,
                'ticket' => '#XAU-H' . (700 + $j),
                'symbol' => 'XAUUSD',
                'type' => $type,
                'lot_size' => rand(5, 50) / 100,
                'open_price' => 2020 + rand(0, 100) / 10,
                'close_price' => 2020 + rand(0, 100) / 10,
                'pnl' => $pnl,
                'is_active' => false,
                'closed_at' => now()->subHours(rand(1, 200)),
                'created_at' => now()->subHours(rand(201, 300)),
            ]);
        }

        // 7. Admin Notification
        $admin = User::where('type', UserType::Admin)->first();
        if ($admin) {
            Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $user->id,
                'title' => 'مرحباً بك في لوحة NiroNex',
                'body' => 'أهلاً بك صقر! لقد تم إعداد حسابك بنجاح. يمكنك الآن الاطلاع على كامل المميزات والإحصائيات.',
                'is_read' => false,
            ]);
        }
    }
}
