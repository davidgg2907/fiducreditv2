<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('line_id')->constrained('credit_lines')->restrictOnDelete();
            $table->foreignUuid('channel_id')->constrained('credit_payment_channels')->restrictOnDelete();
            $table->foreignUuid('source_bank_account_id')->nullable()->constrained('credit_client_bank_accounts')->restrictOnDelete();
            $table->string('payment_number',70)->unique();
            $table->string('external_reference',120)->nullable();
            $table->decimal('amount',18,2);
            $table->string('currency',3)->default('MXN');
            $table->date('value_date');
            $table->dateTime('received_at');
            $table->dateTime('posted_at')->nullable();
            $table->string('status',30)->default('received');
            $table->boolean('third_party')->default(false);
            $table->string('payer_name')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->unique(['channel_id','external_reference'],'payments_channel_external_unique');
            $table->index(['loan_id','value_date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_payments');
    }
};
