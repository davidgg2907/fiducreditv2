<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_drawdowns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('line_id')->constrained('credit_lines')->restrictOnDelete();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->foreignUuid('bank_account_id')->constrained('credit_client_bank_accounts')->restrictOnDelete();
            $table->string('draw_number',50)->unique();
            $table->decimal('amount',18,2);
            $table->string('status',30)->default('requested');
            $table->date('value_date');
            $table->dateTime('executed_at')->nullable();
            $table->string('external_reference',120)->nullable();
            $table->foreignId('requested_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('authorized_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_drawdowns');
    }
};
