<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('second_last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('rfc',13)->nullable();
            $table->string('curp',18)->nullable();
            $table->string('ine_folio')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('nss')->nullable();
            $table->string('health_provider')->nullable();
            $table->string('email')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('status')->default('active');
            $table->index(['company_id','rfc']);
            $table->index(['company_id','curp']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_clients'); }
};
