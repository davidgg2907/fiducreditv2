<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_cases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->foreignUuid('source_alert_id')->constrained('pld_alerts')->restrictOnDelete();
            $table->string('case_number',70)->unique();
            $table->string('status',30)->default('open');
            $table->string('risk_level',20);
            $table->foreignId('compliance_officer_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->dateTime('opened_at');
            $table->dateTime('closed_at')->nullable();
            $table->text('resolution')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_cases');
    }
};
