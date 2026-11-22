<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_sla', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('step_id')->unique()->constrained('credit_workflow_steps')->restrictOnDelete();
            $table->unsignedInteger('target_minutes');
            $table->unsignedInteger('warning_minutes')->nullable();
            $table->unsignedInteger('escalation_minutes')->nullable();
            $table->string('calendar_type',30)->default('business_hours');
            $table->string('timezone',64)->default('America/Mexico_City');
            $table->foreignId('escalation_role_id')->nullable()->constrained('roles')->restrictOnDelete();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_sla');
    }
};
