<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_restructures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('new_terms_id')->constrained('credit_loan_terms')->restrictOnDelete();
            $table->foreignUuid('new_schedule_id')->nullable()->constrained('credit_amortization_schedules')->restrictOnDelete();
            $table->string('restructure_number',70)->unique();
            $table->string('reason',200);
            $table->date('effective_date');
            $table->string('status',30)->default('pending');
            $table->foreignId('approved_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loan_restructures');
    }
};
