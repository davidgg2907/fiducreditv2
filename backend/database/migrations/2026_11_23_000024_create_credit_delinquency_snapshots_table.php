<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_delinquency_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('credit_loans')->restrictOnDelete();
            $table->date('as_of_date');
            $table->unsignedInteger('days_past_due');
            $table->unsignedSmallInteger('overdue_installments');
            $table->decimal('overdue_principal',18,2);
            $table->decimal('overdue_interest',18,2);
            $table->decimal('penalty_interest',18,2);
            $table->string('bucket',30);
            $table->unique(['loan_id','as_of_date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_delinquency_snapshots');
    }
};
