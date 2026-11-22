<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->string('event_type');
            $table->json('before_data')->nullable();
            $table->json('after_data')->nullable();
            $table->string('ip_address',45)->nullable();
            $table->dateTime('occurred_at');
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_events'); }
};
