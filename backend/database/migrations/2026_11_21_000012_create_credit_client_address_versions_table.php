<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_client_address_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('address_id')->constrained('credit_client_addresses')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->string('street');
            $table->string('exterior_number')->nullable();
            $table->string('interior_number')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('municipality');
            $table->string('state');
            $table->string('postal_code',10);
            $table->string('country',2)->default('MX');
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->string('source')->default('customer');
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->unique(['address_id','version']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_client_address_versions'); }
};
