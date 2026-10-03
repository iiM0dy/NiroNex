<?php

use App\Enums\TransactionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('robot_settings', function (Blueprint $table) {
            $table->decimal('wallet_percentage', 5, 2)->nullable()->after('stop_loss');
            $table->decimal('pep_price', 10, 2)->nullable()->after('wallet_percentage');
            $table->decimal('allocation_amount', 20, 6)->nullable()->after('pep_price');
            $table->tinyInteger('status')->default(TransactionStatus::Pending->value)->after('allocation_amount');
            $table->foreignId('transaction_request_id')->nullable()->after('status')->constrained('transaction_requests')->nullOnDelete();
            $table->foreignId('allocation_transaction_id')->nullable()->after('transaction_request_id')->constrained('transactions')->nullOnDelete();
            $table->foreignId('refund_transaction_id')->nullable()->after('allocation_transaction_id')->constrained('transactions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('robot_settings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('refund_transaction_id');
            $table->dropConstrainedForeignId('allocation_transaction_id');
            $table->dropConstrainedForeignId('transaction_request_id');
            $table->dropColumn([
                'status',
                'allocation_amount',
                'pep_price',
                'wallet_percentage',
            ]);
        });
    }
};
