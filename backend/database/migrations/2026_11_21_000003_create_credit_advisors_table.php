<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_advisors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->foreignUuid('branch_id')->constrained('credit_branches')->restrictOnDelete();
            $table->string('employee_code');
            $table->boolean('active')->default(true);
            $table->unique(['company_id','employee_code']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_advisors'); }
};
