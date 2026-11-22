<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_balances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->unique()->constrained('credit_loans')->restrictOnDelete();
            $table->decimal('principal_due',18,2)->default(0);
            $table->decimal('ordinary_interest_due',18,2)->default(0);
            $table->decimal('penalty_interest_due',18,2)->default(0);
            $table->decimal('tax_due',18,2)->default(0);
            $table->decimal('fee_due',18,2)->default(0);
            $table->decimal('unapplied_payments',18,2)->default(0);
            $table->decimal('total_due',18,2)->default(0);
            $table->date('as_of_date');
            $table->unsignedInteger('lock_version')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loan_balances');
    }
};
