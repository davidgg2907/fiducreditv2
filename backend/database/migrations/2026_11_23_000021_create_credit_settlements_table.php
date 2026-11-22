<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_settlements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('quote_id')->constrained('credit_payoff_quotes')->restrictOnDelete();
            $table->foreignUuid('payment_id')->nullable()->constrained('credit_payments')->restrictOnDelete();
            $table->string('settlement_number',70)->unique();
            $table->date('value_date');
            $table->decimal('settled_amount',18,2);
            $table->string('status',30)->default('pending');
            $table->dateTime('completed_at')->nullable();
            $table->foreignId('authorized_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_settlements');
    }
};
