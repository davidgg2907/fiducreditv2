<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->foreignUuid('origin_application_id')->unique()->constrained('credit_applications')->restrictOnDelete();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->foreignUuid('policy_id')->constrained('credit_line_policies')->restrictOnDelete();
            $table->string('line_number',50)->unique();
            $table->string('status',30)->default('approved');
            $table->string('currency',3)->default('MXN');
            $table->decimal('authorized_limit',18,2);
            $table->decimal('committed_amount',18,2)->default(0);
            $table->decimal('outstanding_principal',18,2)->default(0);
            $table->decimal('available_amount',18,2);
            $table->date('effective_date');
            $table->date('expiration_date')->nullable();
            $table->foreignId('authorized_by')->constrained('users')->restrictOnDelete();
            $table->dateTime('authorized_at');
            $table->unsignedInteger('lock_version')->default(0);
            $table->index(['client_id','status']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_lines');
    }
};
