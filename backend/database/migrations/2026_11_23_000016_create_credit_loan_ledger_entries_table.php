<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_ledger_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('payment_id')->nullable()->constrained('credit_payments')->restrictOnDelete();
            $table->foreignUuid('drawdown_id')->nullable()->constrained('credit_drawdowns')->restrictOnDelete();
            $table->string('entry_number',90)->unique();
            $table->string('entry_type',50);
            $table->string('component',35);
            $table->string('direction',6);
            $table->decimal('amount',18,2);
            $table->string('currency',3)->default('MXN');
            $table->date('value_date');
            $table->dateTime('posted_at');
            $table->foreignUuid('reversal_of_id')->nullable()->constrained('credit_loan_ledger_entries')->restrictOnDelete();
            $table->string('idempotency_key',120)->unique();
            $table->json('metadata')->nullable();
            $table->index(['loan_id','value_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loan_ledger_entries');
    }
};
