<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_amortization_installments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('schedule_id')->constrained('credit_amortization_schedules')->restrictOnDelete();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->unsignedInteger('installment_number');
            $table->date('period_start');
            $table->date('due_date');
            $table->decimal('opening_principal',18,2);
            $table->decimal('principal_due',18,2);
            $table->decimal('ordinary_interest_due',18,2);
            $table->decimal('tax_due',18,2)->default(0);
            $table->decimal('fee_due',18,2)->default(0);
            $table->decimal('scheduled_total',18,2);
            $table->decimal('closing_principal',18,2);
            $table->decimal('principal_paid',18,2)->default(0);
            $table->decimal('interest_paid',18,2)->default(0);
            $table->decimal('tax_paid',18,2)->default(0);
            $table->decimal('fee_paid',18,2)->default(0);
            $table->string('status',25)->default('pending');
            $table->unique(['schedule_id','installment_number'],'loan_installment_schedule_number_unique');
            $table->index(['loan_id','due_date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_amortization_installments');
    }
};
