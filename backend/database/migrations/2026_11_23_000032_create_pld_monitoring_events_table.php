<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_monitoring_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->foreignUuid('line_id')->nullable()->constrained('credit_lines')->restrictOnDelete();
            $table->foreignUuid('loan_id')->nullable()->constrained('credit_loans')->restrictOnDelete();
            $table->foreignUuid('payment_id')->nullable()->constrained('credit_payments')->restrictOnDelete();
            $table->foreignUuid('drawdown_id')->nullable()->constrained('credit_drawdowns')->restrictOnDelete();
            $table->foreignUuid('settlement_id')->nullable()->constrained('credit_settlements')->restrictOnDelete();
            $table->foreignUuid('policy_version_id')->constrained('pld_policy_versions')->restrictOnDelete();
            $table->string('event_key',120)->unique();
            $table->string('event_type',50);
            $table->decimal('amount',18,2)->nullable();
            $table->string('currency',3)->default('MXN');
            $table->date('value_date');
            $table->dateTime('observed_at');
            $table->json('facts')->nullable();
            $table->string('evaluation_status',30)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_monitoring_events');
    }
};
