<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_bureau_inquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->string('provider');
            $table->unsignedSmallInteger('score')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('result')->default('pending');
            $table->string('report_storage_path')->nullable();
            $table->dateTime('consulted_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_bureau_inquiries'); }
};
