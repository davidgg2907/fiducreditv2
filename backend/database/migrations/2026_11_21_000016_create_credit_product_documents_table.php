<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_product_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->foreignUuid('document_type_id')->constrained('credit_document_types')->restrictOnDelete();
            $table->boolean('required')->default(true);
            $table->unsignedSmallInteger('min_files')->default(1);
            $table->unsignedSmallInteger('max_files')->default(1);
            $table->unsignedInteger('display_order')->default(0);
            $table->unique(['product_version_id','document_type_id'],'product_document_version_type_unique');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_product_documents'); }
};
