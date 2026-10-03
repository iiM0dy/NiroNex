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
        Schema::table('transaction_requests', function (Blueprint $table) {
            $table->foreignId('receiver_id')->nullable()->constrained('users')->nullOnDelete()->after('user_id');
            $table->text('note')->nullable()->after('receiver_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('receiver_id');
            $table->dropColumn('note');
        });
    }
};
