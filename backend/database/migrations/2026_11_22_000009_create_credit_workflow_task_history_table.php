<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_task_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('task_id')->constrained('credit_workflow_tasks')->restrictOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->string('event_type',50);
            $table->string('from_status',30)->nullable();
            $table->string('to_status',30)->nullable();
            $table->foreignId('previous_assignee')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('new_assignee')->nullable()->constrained('users')->restrictOnDelete();
            $table->text('reason')->nullable();
            $table->json('details')->nullable();
            $table->dateTime('occurred_at');
            $table->index(['task_id','occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_task_history');
    }
};
