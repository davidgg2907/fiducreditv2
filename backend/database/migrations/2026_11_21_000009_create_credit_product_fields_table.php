<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_product_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->foreignUuid('custom_field_id')->constrained('credit_custom_fields')->restrictOnDelete();
            $table->string('scope')->default('application');
            $table->boolean('required')->default(false);
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->unique(['product_version_id','custom_field_id','scope'],'product_fields_version_field_scope_unique');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_product_fields'); }
};
