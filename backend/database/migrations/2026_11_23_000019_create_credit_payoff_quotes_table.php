<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payoff_quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->string('quote_number',70)->unique();
            $table->date('value_date');
            $table->dateTime('expires_at');
            $table->decimal('principal_amount',18,2);
            $table->decimal('interest_amount',18,2);
            $table->decimal('penalty_amount',18,2);
            $table->decimal('tax_amount',18,2);
            $table->decimal('fees_amount',18,2);
            $table->decimal('credits_amount',18,2)->default(0);
            $table->decimal('total_to_settle',18,2);
            $table->string('status',30)->default('quoted');
            $table->foreignId('generated_by')->constrained('users')->restrictOnDelete();
            $table->json('calculation_snapshot')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_payoff_quotes');
    }
};
