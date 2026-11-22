<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_adjustments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->string('adjustment_number',70)->unique();
            $table->string('component',40);
            $table->string('adjustment_type',40);
            $table->decimal('amount',18,2);
            $table->date('value_date');
            $table->string('reason',250);
            $table->foreignId('approved_by')->constrained('users')->restrictOnDelete();
            $table->string('status',30)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loan_adjustments');
    }
};
