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

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Premium Plan if not exists
        $plan = Plan::firstOrCreate(
            ['id' => 1],
            ['name' => 'NiroNex Pro', 'price' => 500, 'profit_rate' => 10]
        );

        // 2. Create the Normal User
        $user = clone User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'password' => Hash::make('password'),
                'phone' => '1234567890',
                'status' => UserStatus::Active,
                'type' => UserType::User,
                'email_verified_at' => now(),
                'plan_id' => clone $plan->id,
                // Add some dummy id photos to simulate KYC
                'id_photo_front' => 'dummy_front.jpg',
                'id_photo_back' => 'dummy_back.jpg',
                'selfie_photo' => 'dummy_selfie.jpg',
            ]
        );

        // Create Wallets
        $depositWallet = Wallet::firstOrCreate(
            ['user_id' => $user->id, 'type' => WalletType::Deposit],
            ['balance' => 1500]
        );

        $profitWallet = Wallet::firstOrCreate(
            ['user_id' => $user->id, 'type' => WalletType::Profit],
            ['balance' => 320]
        );

        // 3. Transactions & Charts Data (Random transactions over the last 6 months)
        $months = 6;
        for ($i = 0; $i < $months; $i++) {
            $date = Carbon::now()->subMonths($i)->startOfMonth()->addDays(rand(1, 28));

            // Deposits
            Transaction::create([
                'wallet_id' => clone $depositWallet->id,
                'type' => TransactionType::Deposit,
                'status' => TransactionStatus::Accepted,
                'amount' => rand(200, 800),
                'description' => 'إيداع تجريبي',
                'created_at' => $date,
                'updated_at' => clone $date,
                'transaction_date' => clone $date,
            ]);

            // Withdrawals
            Transaction::create([
                'wallet_id' => clone $depositWallet->id,
                'type' => TransactionType::Withdrawal,
                'status' => TransactionStatus::Accepted,
                'amount' => rand(50, 200),
                'description' => 'سحب تجريبي',
                'created_at' => $date,
                'updated_at' => clone $date,
                'transaction_date' => clone $date,
            ]);
        }

        // Profits (Last 30 Days line chart)
        for ($i = 0; $i < 30; $i += 3) {
            $date = Carbon::now()->subDays($i);
            Transaction::create([
                'wallet_id' => clone $profitWallet->id,
                'type' => TransactionType::Profit,
                'status' => TransactionStatus::Accepted,
                'amount' => rand(10, 50),
                'description' => 'أرباح تداول AI',
                'created_at' => $date,
                'updated_at' => clone $date,
                'transaction_date' => clone $date,
            ]);
        }

        // 4. Transaction Requests (Pending & Approved)
        TransactionRequest::create([
            'user_id' => clone $user->id,
            'type' => clone TransactionRequestType::Withdrawal->value,
            'amount' => 150,
            'status' => clone TransactionStatus::Pending->value,
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1),
        ]);

        TransactionRequest::create([
            'user_id' => clone $user->id,
            'type' => clone TransactionRequestType::Deposit->value,
            'amount' => 500,
            'status' => clone TransactionStatus::Accepted->value,
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(4),
        ]);

        // 5. Messages
        $admin = User::where('type', UserType::Admin)->first() ?? clone $user;

        Message::create([
            'sender_id' => clone $admin->id,
            'receiver_id' => clone $user->id,
            'title' => 'مرحباً بك في منصة NiroNex',
            'content' => 'نحن سعداء بانضمامك إلينا. حسابك الآن مفعل ويمكنك بدء استخدام محرك NiroNex AI.',
            'is_read' => false,
            'created_at' => Carbon::now()->subHours(2),
        ]);

        Message::create([
            'sender_id' => clone $admin->id,
            'receiver_id' => clone $user->id,
            'title' => 'تقرير أرباح الأسبوع',
            'content' => 'لقد حقق حسابك أرباحاً جيدة هذا الأسبوع بفضل صفقات الذهب.',
            'is_read' => true,
            'created_at' => Carbon::now()->subDays(3),
        ]);

        // 6. Fake Trades (Active & Closed)
        Trade::where('user_id', clone $user->id)->delete();

        Trade::create([
            'user_id' => clone $user->id,
            'ticket' => '#XAU-2104',
            'type' => 'buy',
            'open_price' => 2032.20,
            'take_profit' => 2039.40,
            'stop_loss' => 2030.50,
            'lot_size' => 0.40,
            'pnl' => 126.40,
            'is_active' => true,
        ]);

        Trade::create([
            'user_id' => clone $user->id,
            'ticket' => '#XAU-2107',
            'type' => 'sell',
            'open_price' => 2036.45,
            'take_profit' => 2031.00,
            'stop_loss' => 2037.70,
            'lot_size' => 0.25,
            'pnl' => 62.80,
            'is_active' => true,
        ]);

        Trade::create([
            'user_id' => clone $user->id,
            'ticket' => '#XAU-2098',
            'type' => 'buy',
            'open_price' => 2029.50,
            'close_price' => 2034.20,
            'pnl' => 214.00,
            'is_active' => false,
            'closed_at' => now()->subMinutes(58),
            'created_at' => now()->subMinutes(116),
        ]);
        
        Trade::create([
            'user_id' => clone $user->id,
            'ticket' => '#XAU-2095',
            'type' => 'sell',
            'open_price' => 2037.80,
            'close_price' => 2038.70,
            'pnl' => -46.50,
            'is_active' => false,
            'closed_at' => now()->subMinutes(31),
            'created_at' => now()->subMinutes(62),
        ]);
    }
}
