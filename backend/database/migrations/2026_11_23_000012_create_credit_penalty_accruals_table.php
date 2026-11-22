<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_penalty_accruals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('installment_id')->nullable()->constrained('credit_amortization_installments')->restrictOnDelete();
            $table->date('period_start');
            $table->date('period_end');
            $table->date('value_date');
            $table->unsignedInteger('days_overdue');
            $table->decimal('overdue_basis',18,2);
            $table->decimal('annual_rate',12,8);
            $table->decimal('penalty_interest',18,2);
            $table->decimal('tax_amount',18,2)->default(0);
            $table->string('calculation_key',100)->unique();
            $table->boolean('reversed')->default(false);
            $table->dateTime('calculated_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_penalty_accruals');
    }
};
