<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payment_allocations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('payment_id')->constrained('credit_payments')->restrictOnDelete();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('installment_id')->nullable()->constrained('credit_amortization_installments')->restrictOnDelete();
            $table->string('component',35);
            $table->decimal('amount',18,2);
            $table->unsignedSmallInteger('allocation_order');
            $table->date('value_date');
            $table->string('status',25)->default('posted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_payment_allocations');
    }
};
