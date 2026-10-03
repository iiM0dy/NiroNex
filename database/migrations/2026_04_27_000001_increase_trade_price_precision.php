<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->decimal('open_price', 20, 8)->change();
            $table->decimal('close_price', 20, 8)->nullable()->change();
            $table->decimal('take_profit', 20, 8)->nullable()->change();
            $table->decimal('stop_loss', 20, 8)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->decimal('open_price', 15, 2)->change();
            $table->decimal('close_price', 15, 2)->nullable()->change();
            $table->decimal('take_profit', 15, 2)->nullable()->change();
            $table->decimal('stop_loss', 15, 2)->nullable()->change();
        });
    }
};
