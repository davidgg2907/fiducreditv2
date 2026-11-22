<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_screenings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->foreignUuid('loan_id')->nullable()->constrained('credit_loans')->restrictOnDelete();
            $table->string('screening_type',50);
            $table->string('provider',100);
            $table->string('list_version',100)->nullable();
            $table->string('result',30);
            $table->string('external_reference',150)->nullable();
            $table->string('evidence_path')->nullable();
            $table->dateTime('screened_at');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_screenings');
    }
};
