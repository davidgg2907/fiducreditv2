<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('line_id')->constrained('credit_lines')->restrictOnDelete();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->string('contract_number',70)->unique();
            $table->string('document_version',30);
            $table->string('storage_disk',40)->nullable();
            $table->string('storage_path')->nullable();
            $table->string('sha256',64)->nullable();
            $table->dateTime('signed_at')->nullable();
            $table->string('status',30)->default('pending');
            $table->json('signer_snapshot')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_contracts');
    }
};
