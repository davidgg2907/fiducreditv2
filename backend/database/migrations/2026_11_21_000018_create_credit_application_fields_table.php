<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignUuid('custom_field_id')->constrained('credit_custom_fields')->restrictOnDelete();
            $table->json('field_value')->nullable();
            $table->unique(['application_id','custom_field_id']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_fields'); }
};
