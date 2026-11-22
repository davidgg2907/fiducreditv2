<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_alert_actions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('alert_id')->constrained('pld_alerts')->restrictOnDelete();
            $table->foreignId('actor_id')->constrained('users')->restrictOnDelete();
            $table->string('action',60);
            $table->string('from_status',30)->nullable();
            $table->string('to_status',30)->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('occurred_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_alert_actions');
    }
};
