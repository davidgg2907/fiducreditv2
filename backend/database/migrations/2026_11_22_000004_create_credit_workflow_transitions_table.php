<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_transitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('workflow_version_id')->constrained('credit_workflow_versions')->restrictOnDelete();
            $table->foreignUuid('from_step_id')->constrained('credit_workflow_steps')->restrictOnDelete();
            $table->foreignUuid('to_step_id')->constrained('credit_workflow_steps')->restrictOnDelete();
            $table->string('code',60);
            $table->string('name',120);
            $table->string('action',40);
            $table->boolean('requires_reason')->default(false);
            $table->boolean('requires_authorization')->default(false);
            $table->boolean('enabled')->default(true);
            $table->unique(['workflow_version_id','code'],'cw_transitions_version_code_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_transitions');
    }
};
