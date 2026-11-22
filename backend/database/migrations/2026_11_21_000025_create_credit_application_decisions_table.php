<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_decisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignId('decided_by')->constrained('users')->restrictOnDelete();
            $table->string('decision');
            $table->decimal('approved_amount',18,2)->nullable();
            $table->text('reason')->nullable();
            $table->dateTime('decided_at');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_decisions'); }
};
