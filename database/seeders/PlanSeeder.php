<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'aliases' => ['Start', 'Starter'],
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
            [
                'aliases' => ['Trader'],
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
        ];

        foreach ($plans as $plan) {
            $aliases = $plan['aliases'];
            unset($plan['aliases']);

            $existing = Plan::query()
                ->whereIn('name', $aliases)
                ->orderBy('id')
                ->first();

            if ($existing) {
                $existing->fill($plan)->save();
                continue;
            }

            Plan::create($plan);
        }
    }
}
