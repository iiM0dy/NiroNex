<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $definitions = [
            [
                'aliases' => ['Start', 'Starter'],
                'data' => [
                    'name' => 'Starter',
                    'description' => 'خطة بداية مرنة مع تشغيل دوري كل 7 أيام وعرض ربح متدرج للمشتركين الجدد.',
                    'profit_rate' => 20,
                    'min_deposit' => 20,
                    'max_deposit' => 499,
                    'duration_days' => 7,
                    'instant_withdrawal' => true,
                    'weekly_support' => true,
                    'privet_manger' => false,
                    'recommendation' => false,
                ],
            ],
            [
                'aliases' => ['Trader'],
                'data' => [
                    'name' => 'Trader',
                    'description' => 'خطة تشغيل متوسطة بمدة 14 يوماً وعائد فعلي أعلى للمشتركين الباحثين عن نمو أسرع.',
                    'profit_rate' => 40,
                    'min_deposit' => 500,
                    'max_deposit' => 5000,
                    'duration_days' => 14,
                    'instant_withdrawal' => true,
                    'weekly_support' => true,
                    'privet_manger' => false,
                    'recommendation' => true,
                ],
            ],
            [
                'aliases' => ['Elite', 'Robot'],
                'data' => [
                    'name' => 'Robot',
                    'description' => 'اشتراك يفتح صفحة الروبوت وإعدادات التداول الآلي مع حد أدنى منخفض وإتاحة واسعة للإيداع.',
                    'profit_rate' => 18,
                    'min_deposit' => 20,
                    'max_deposit' => 999999.99,
                    'duration_days' => 30,
                    'instant_withdrawal' => true,
                    'weekly_support' => true,
                    'privet_manger' => true,
                    'recommendation' => false,
                ],
            ],
        ];

        foreach ($definitions as $definition) {
            $existing = DB::table('plans')
                ->whereIn('name', $definition['aliases'])
                ->orderBy('id')
                ->first();

            $payload = array_merge($definition['data'], ['updated_at' => $now]);

            if ($existing) {
                DB::table('plans')
                    ->where('id', $existing->id)
                    ->update($payload);

                continue;
            }

            DB::table('plans')->insert(array_merge($payload, ['created_at' => $now]));
        }
    }

    public function down(): void
    {
        // Intentionally left empty because this migration syncs live business rules.
    }
};
