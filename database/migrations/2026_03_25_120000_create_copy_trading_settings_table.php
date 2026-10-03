<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('copy_trading_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('source_account')->nullable();
            $table->decimal('capital_percentage', 5, 2)->default(10.00);
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('medium');
            $table->decimal('stop_copy_loss', 10, 2)->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('copy_trading_settings');
    }
};
