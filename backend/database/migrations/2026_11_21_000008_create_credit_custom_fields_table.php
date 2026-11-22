<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_custom_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('field_key');
            $table->string('label');
            $table->string('data_type');
            $table->json('options')->nullable();
            $table->boolean('sensitive')->default(false);
            $table->unique(['company_id','field_key']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_custom_fields'); }
};
