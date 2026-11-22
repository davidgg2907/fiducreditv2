<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_case_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('case_id')->constrained('pld_cases')->restrictOnDelete();
            $table->foreignId('actor_id')->constrained('users')->restrictOnDelete();
            $table->string('action',60);
            $table->text('notes')->nullable();
            $table->string('evidence_path')->nullable();
            $table->dateTime('occurred_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_case_events');
    }
};
