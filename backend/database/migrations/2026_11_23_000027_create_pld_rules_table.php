<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('policy_version_id')->constrained('pld_policy_versions')->restrictOnDelete();
            $table->string('code',70);
            $table->string('name',150);
            $table->string('event_type',40);
            $table->string('rule_type',50);
            $table->json('parameters');
            $table->string('severity',20)->default('medium');
            $table->boolean('blocking')->default(false);
            $table->boolean('enabled')->default(true);
            $table->unique(['policy_version_id','code']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_rules');
    }
};
