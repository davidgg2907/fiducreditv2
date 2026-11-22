<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payment_application_priorities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('policy_id')->constrained('credit_payment_application_policies')->restrictOnDelete();
            $table->string('component',40);
            $table->unsignedSmallInteger('priority');
            $table->boolean('enabled')->default(true);
            $table->unique(['policy_id','component']);
            $table->unique(['policy_id','priority']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_payment_application_priorities');
    }
};
