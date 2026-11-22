<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignUuid('document_type_id')->constrained('credit_document_types')->restrictOnDelete();
            $table->foreignUuid('previous_document_id')->nullable()->constrained('credit_application_documents')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->string('storage_disk');
            $table->string('storage_path');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('size_bytes');
            $table->string('sha256',64);
            $table->string('status')->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->dateTime('validated_at')->nullable();
            $table->index(['application_id','document_type_id','version'],'application_document_version_lookup');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_documents'); }
};
