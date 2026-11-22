<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_client_bank_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->string('bank_code',5)->nullable();
            $table->string('bank_name');
            $table->string('holder_name');
            $table->string('clabe',18)->nullable();
            $table->string('account_last4',4)->nullable();
            $table->string('account_type')->default('checking');
            $table->boolean('verified')->default(false);
            $table->boolean('primary')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_client_bank_accounts'); }
};
