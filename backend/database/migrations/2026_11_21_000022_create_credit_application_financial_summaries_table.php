<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_financial_summaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->decimal('monthly_income',18,2);
            $table->decimal('monthly_expenses',18,2);
            $table->decimal('monthly_debt_obligations',18,2);
            $table->decimal('proposed_monthly_payment',18,2)->default(0);
            $table->decimal('disposable_income',18,2);
            $table->decimal('debt_to_income_ratio',9,6);
            $table->string('result')->default('pending');
            $table->foreignId('analyzed_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_financial_summaries'); }
};
