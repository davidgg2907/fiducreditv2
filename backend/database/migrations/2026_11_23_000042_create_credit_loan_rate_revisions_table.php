<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_rate_revisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('terms_id')->constrained('credit_loan_terms')->restrictOnDelete();
            $table->date('effective_date');
            $table->decimal('previous_annual_rate',12,8)->nullable();
            $table->decimal('new_annual_rate',12,8);
            $table->string('rate_reference',100)->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('authorized_by')->constrained('users')->restrictOnDelete();
            $table->unique(['loan_id','effective_date']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_loan_rate_revisions');
    }
};
