<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('line_id')->constrained('credit_lines')->restrictOnDelete();
            $table->foreignUuid('drawdown_id')->unique()->constrained('credit_drawdowns')->restrictOnDelete();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignUuid('contract_id')->nullable()->constrained('credit_contracts')->restrictOnDelete();
            $table->string('loan_number',60)->unique();
            $table->string('status',30)->default('pending_disbursement');
            $table->string('currency',3)->default('MXN');
            $table->decimal('original_principal',18,2);
            $table->decimal('principal_outstanding',18,2);
            $table->date('start_date');
            $table->date('maturity_date');
            $table->unsignedSmallInteger('term_count');
            $table->string('term_unit',20)->default('month');
            $table->date('last_accrual_date')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->unsignedInteger('lock_version')->default(0);
            $table->index(['line_id','status']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loans');
    }
};
