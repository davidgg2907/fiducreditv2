<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_financial_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->string('entry_type');
            $table->string('concept');
            $table->string('counterparty')->nullable();
            $table->decimal('amount',18,2);
            $table->string('frequency');
            $table->boolean('verified')->default(false);
            $table->text('observations')->nullable();
            $table->foreignId('captured_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_financial_items'); }
};
