<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('workflow_version_id')->constrained('credit_workflow_versions')->restrictOnDelete();
            $table->string('code',60);
            $table->string('name',160);
            $table->string('step_type',40);
            $table->string('application_status',40);
            $table->string('application_substatus',60)->nullable();
            $table->unsignedInteger('sort_order');
            $table->boolean('is_initial')->default(false);
            $table->boolean('is_terminal')->default(false);
            $table->boolean('allow_manual_assignment')->default(true);
            $table->json('metadata')->nullable();
            $table->unique(['workflow_version_id','code'],'cw_steps_version_code_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_steps');
    }
};
