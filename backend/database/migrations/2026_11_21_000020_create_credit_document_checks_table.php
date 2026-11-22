<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_document_checks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_document_id')->constrained('credit_application_documents')->restrictOnDelete();
            $table->foreignUuid('validation_rule_id')->constrained('credit_document_validation_rules')->restrictOnDelete();
            $table->string('result');
            $table->text('observations')->nullable();
            $table->foreignId('checked_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->dateTime('checked_at');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_document_checks'); }
};
