<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_line_limit_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('line_id')->constrained('credit_lines')->restrictOnDelete();
            $table->decimal('previous_limit',18,2);
            $table->decimal('new_limit',18,2);
            $table->string('reason',200);
            $table->foreignUuid('source_application_id')->nullable()->constrained('credit_applications')->restrictOnDelete();
            $table->foreignId('authorized_by')->constrained('users')->restrictOnDelete();
            $table->dateTime('effective_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_line_limit_history');
    }
};
