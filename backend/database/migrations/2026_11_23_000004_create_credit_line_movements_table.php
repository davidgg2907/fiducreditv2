<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_line_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('line_id')->constrained('credit_lines')->restrictOnDelete();
            $table->string('movement_type',40);
            $table->decimal('amount',18,2);
            $table->decimal('available_before',18,2);
            $table->decimal('available_after',18,2);
            $table->foreignUuid('loan_id')->nullable();
            $table->string('reference',100)->unique();
            $table->date('value_date');
            $table->dateTime('recorded_at');
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->json('metadata')->nullable();
            $table->index(['line_id','value_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_line_movements');
    }
};
