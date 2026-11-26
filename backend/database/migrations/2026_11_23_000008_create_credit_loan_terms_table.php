<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_terms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->string('interest_rate_type',30)->default('fija');
            $table->decimal('ordinary_annual_rate',12,8);
            $table->decimal('default_annual_rate',12,8)->default(0);
            $table->string('day_count_convention',30)->default('ACT_365');
            $table->string('amortization_method',30)->default('frances');
            $table->string('payment_frequency',30)->default('mensual');
            $table->string('interest_calculation',30)->default('saldo_insoluto');
            $table->string('rounding_mode',30)->default('half_up');
            $table->unsignedSmallInteger('grace_days')->default(0);
            $table->boolean('tax_on_interest')->default(false);
            $table->decimal('tax_rate',9,6)->default(0);
            $table->date('valid_from');
            $table->date('valid_to')->nullable();
            $table->json('terms_snapshot')->nullable();
            $table->unique(['loan_id','version']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loan_terms');
    }
};
