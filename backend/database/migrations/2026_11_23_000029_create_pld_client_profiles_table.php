<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_client_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->foreignUuid('policy_version_id')->constrained('pld_policy_versions')->restrictOnDelete();
            $table->string('risk_level',25);
            $table->string('occupation')->nullable();
            $table->string('economic_activity')->nullable();
            $table->string('funds_origin')->nullable();
            $table->decimal('expected_monthly_volume',18,2)->nullable();
            $table->unsignedInteger('expected_monthly_operations')->nullable();
            $table->string('residency_country',2)->default('MX');
            $table->boolean('pep_declared')->default(false);
            $table->dateTime('assessed_at');
            $table->dateTime('next_review_at')->nullable();
            $table->foreignId('assessed_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->index(['client_id','assessed_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_client_profiles');
    }
};
