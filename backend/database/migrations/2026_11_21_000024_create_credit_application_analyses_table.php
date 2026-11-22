<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_analyses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignId('analyst_id')->constrained('users')->restrictOnDelete();
            $table->string('status')->default('in_progress');
            $table->text('findings')->nullable();
            $table->text('recommendation')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_analyses'); }
};
