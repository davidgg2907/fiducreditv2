<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('instance_id')->constrained('credit_workflow_instances')->restrictOnDelete();
            $table->foreignUuid('step_id')->constrained('credit_workflow_steps')->restrictOnDelete();
            $table->foreignUuid('branch_id')->nullable()->constrained('credit_branches')->restrictOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('assigned_role_id')->nullable()->constrained('roles')->restrictOnDelete();
            $table->string('task_type',40);
            $table->string('status',30)->default('pending');
            $table->unsignedSmallInteger('priority')->default(3);
            $table->dateTime('due_at')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->index(['status','due_at']);
            $table->index(['assigned_to','status']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_tasks');
    }
};
