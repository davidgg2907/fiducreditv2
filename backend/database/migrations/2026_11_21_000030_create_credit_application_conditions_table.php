<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_conditions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->decimal('annual_interest_rate',9,6);
            $table->string('interest_method');
            $table->unsignedSmallInteger('approved_term');
            $table->string('payment_frequency');
            $table->string('amortization_method');
            $table->decimal('opening_fee',18,2)->default(0);
            $table->dateTime('conditions_accepted_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_conditions'); }
};
