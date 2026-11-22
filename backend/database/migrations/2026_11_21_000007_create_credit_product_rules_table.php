<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_product_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->string('rule_code');
            $table->string('operator');
            $table->json('rule_value');
            $table->string('rejection_reason')->nullable();
            $table->boolean('mandatory')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_product_rules'); }
};
