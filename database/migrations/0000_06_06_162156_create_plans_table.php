<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('min_deposit');
            $table->decimal('max_deposit');
            $table->decimal('profit_rate', 5, 2);
            $table->integer('duration_days');//1 , 7 , 30 
            $table->boolean('instant_withdrawal')->default(0);
            $table->boolean('weekly_support')->default(0);
            $table->boolean('privet_manger')->default(0);
            $table->boolean('recommendation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
