<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_policy_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('policy_id')->constrained('pld_policies')->restrictOnDelete();
            $table->unsignedInteger('version');
            $table->string('status',25)->default('draft');
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->json('monitoring_config')->nullable();
            $table->unique(['policy_id','version']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_policy_versions');
    }
};
