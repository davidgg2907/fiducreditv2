<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_workflow_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('workflow_id')->constrained('credit_workflows')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->string('status',25)->default('draft');
            $table->boolean('is_default')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('retired_at')->nullable();
            $table->foreignId('published_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->string('configuration_hash',64)->nullable();
            $table->unique(['workflow_id','version']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_workflow_versions');
    }
};
