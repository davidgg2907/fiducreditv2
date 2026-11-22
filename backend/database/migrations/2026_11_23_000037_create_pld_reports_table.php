<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('case_id')->constrained('pld_cases')->restrictOnDelete();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('report_type',50);
            $table->string('regulatory_regime',60);
            $table->string('status',30)->default('draft');
            $table->string('external_folio',120)->nullable();
            $table->dateTime('due_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->string('evidence_path')->nullable();
            $table->foreignId('prepared_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_reports');
    }
};
