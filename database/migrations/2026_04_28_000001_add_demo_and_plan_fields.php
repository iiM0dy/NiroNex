<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false)->after('trading_balance');
            $table->decimal('demo_trading_balance', 15, 2)->default(50000.00)->after('is_demo');
            $table->decimal('plan_amount', 15, 2)->default(0.00)->after('plan_id');
        });

        Schema::table('trades', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false)->after('symbol');
        });
    }

    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn('is_demo');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_demo', 'demo_trading_balance', 'plan_amount']);
        });
    }
};
