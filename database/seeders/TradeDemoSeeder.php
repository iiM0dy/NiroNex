<?php

namespace Database\Seeders;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Seeder;

class TradeDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        // Clear existing demo trades for this user to avoid duplicates
        Trade::where('user_id', $user->id)->delete();

        Trade::create([
            'user_id' => $user->id,
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
            'user_id' => $user->id,
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
            'user_id' => $user->id,
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
            'user_id' => $user->id,
            'ticket' => '#XAU-2095',
            'type' => 'sell',
            'open_price' => 2037.80,
            'close_price' => 2038.70,
            'pnl' => -46.50,
            'is_active' => false,
            'closed_at' => now()->subMinutes(31),
            'created_at' => now()->subMinutes(62),
        ]);

        Trade::create([
            'user_id' => $user->id,
            'ticket' => '#XAU-2091',
            'type' => 'buy',
            'open_price' => 2027.20,
            'close_price' => 2032.30,
            'pnl' => 188.90,
            'is_active' => false,
            'closed_at' => now()->subHours(1)->subMinutes(14),
            'created_at' => now()->subHours(2),
        ]);
    }
}
