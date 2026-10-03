<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('robot_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('medium');
            $table->decimal('take_profit', 10, 2)->nullable();
            $table->decimal('stop_loss', 10, 2)->nullable();
            $table->enum('trade_duration', ['weekly', 'biweekly', 'monthly'])->default('weekly');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('robot_settings');
    }
};
