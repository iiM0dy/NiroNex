<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ticket')->unique();
            $table->string('symbol')->default('XAUUSD');
            $table->string('type'); // 'buy', 'sell'
            $table->decimal('lot_size', 10, 2)->default(0.10);
            $table->decimal('open_price', 15, 2);
            $table->decimal('close_price', 15, 2)->nullable();
            $table->decimal('take_profit', 15, 2)->nullable();
            $table->decimal('stop_loss', 15, 2)->nullable();
            $table->decimal('pnl', 15, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
