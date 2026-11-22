<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_amortization_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('terms_id')->constrained('credit_loan_terms')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->string('status',25)->default('active');
            $table->date('calculation_date');
            $table->date('first_due_date');
            $table->decimal('scheduled_principal',18,2);
            $table->decimal('scheduled_interest',18,2);
            $table->decimal('scheduled_total',18,2);
            $table->string('reason',150)->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->unique(['loan_id','version']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_amortization_schedules');
    }
};
