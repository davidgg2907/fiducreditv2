<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_step_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('step_id')->constrained('credit_workflow_steps')->restrictOnDelete();
            $table->foreignUuid('transition_id')->nullable()->constrained('credit_workflow_transitions')->restrictOnDelete();
            $table->string('code',70);
            $table->string('rule_type',50);
            $table->string('operator',15);
            $table->json('parameters');
            $table->boolean('blocking')->default(true);
            $table->boolean('enabled')->default(true);
            $table->unique(['step_id','code']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_step_rules');
    }
};
