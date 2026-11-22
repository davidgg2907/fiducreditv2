<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_document_validation_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_type_id')->constrained('credit_document_types')->restrictOnDelete();
            $table->string('rule_code');
            $table->string('rule_type');
            $table->json('parameters')->nullable();
            $table->boolean('required')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_document_validation_rules'); }
};
