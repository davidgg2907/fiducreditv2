<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_consents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->string('consent_type');
            $table->string('version');
            $table->boolean('accepted');
            $table->dateTime('accepted_at')->nullable();
            $table->string('evidence_storage_path')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_consents'); }
};
