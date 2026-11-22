<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_alerts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('monitoring_event_id')->constrained('pld_monitoring_events')->restrictOnDelete();
            $table->foreignUuid('rule_id')->constrained('pld_rules')->restrictOnDelete();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->string('alert_number',70)->unique();
            $table->string('severity',20);
            $table->string('status',30)->default('open');
            $table->string('reason',250);
            $table->json('evidence')->nullable();
            $table->dateTime('detected_at');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->restrictOnDelete();
            $table->dateTime('resolved_at')->nullable();
            $table->unique(['monitoring_event_id','rule_id'],'pld_alert_event_rule_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_alerts');
    }
};
