<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payment_application_policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->unique()->constrained('credit_product_versions')->restrictOnDelete();
            $table->string('prepayment_mode',40)->default('reduce_term');
            $table->boolean('allow_early_payment')->default(true);
            $table->boolean('recalculate_interest_after_prepayment')->default(true);
            $table->boolean('allow_overpayment')->default(false);
            $table->string('surplus_handling',40)->default('unapplied');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_payment_application_policies');
    }
};
