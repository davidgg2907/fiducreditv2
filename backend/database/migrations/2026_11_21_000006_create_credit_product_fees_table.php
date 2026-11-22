<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_product_fees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('calculation_type');
            $table->decimal('amount',18,4);
            $table->boolean('taxable')->default(false);
            $table->boolean('active')->default(true);
            $table->unique(['product_version_id','code']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_product_fees'); }
};
