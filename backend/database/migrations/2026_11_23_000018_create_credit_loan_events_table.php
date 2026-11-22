<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_loan_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->string('event_type',70);
            $table->string('previous_status',30)->nullable();
            $table->string('new_status',30)->nullable();
            $table->json('payload')->nullable();
            $table->string('correlation_id',100)->nullable();
            $table->dateTime('occurred_at');
            $table->index(['loan_id','occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_loan_events');
    }
};
