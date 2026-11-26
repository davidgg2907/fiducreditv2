<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_product_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('credit_products')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->decimal('min_amount',18,2);
            $table->decimal('max_amount',18,2);
            $table->unsignedSmallInteger('min_term');
            $table->unsignedSmallInteger('max_term');
            $table->string('term_unit')->default('mes');
            $table->decimal('min_annual_rate',9,6);
            $table->decimal('max_annual_rate',9,6);
            $table->string('rate_type')->default('fija');
            $table->string('interest_method')->default('saldo_insoluto');
            $table->decimal('min_dti',7,4)->default(0);
            $table->decimal('max_dti',7,4)->default(0.40);
            $table->unsignedSmallInteger('min_bureau_score')->nullable();
            $table->string('amortization_method')->default('frances');
            $table->string('payment_frequency')->default('mensual');
            $table->string('currency',3)->default('MXN');
            $table->boolean('requires_bureau')->default(true);
            $table->boolean('active')->default(true);
            $table->dateTime('effective_from')->nullable();
            $table->dateTime('effective_to')->nullable();
            $table->unique(['product_id','version']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_product_versions'); }
};
