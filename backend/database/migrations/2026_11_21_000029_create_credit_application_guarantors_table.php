<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_application_guarantors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained('credit_applications')->restrictOnDelete();
            $table->string('full_name');
            $table->string('rfc',13)->nullable();
            $table->string('relationship');
            $table->string('phone',20)->nullable();
            $table->decimal('monthly_income',18,2)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_application_guarantors'); }
};
