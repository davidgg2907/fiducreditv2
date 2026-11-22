<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_instances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->unique()->constrained('credit_applications')->restrictOnDelete();
            $table->foreignUuid('workflow_version_id')->constrained('credit_workflow_versions')->restrictOnDelete();
            $table->foreignUuid('current_step_id')->constrained('credit_workflow_steps')->restrictOnDelete();
            $table->string('status',30)->default('running');
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->foreignId('started_by')->constrained('users')->restrictOnDelete();
            $table->unsignedInteger('lock_version')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_instances');
    }
};
