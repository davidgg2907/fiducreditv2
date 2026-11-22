<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_business_calendars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('code',50);
            $table->string('name',120);
            $table->string('timezone',64)->default('America/Mexico_City');
            $table->json('non_business_weekdays');
            $table->string('due_date_adjustment',40)->default('next_business_day');
            $table->boolean('enabled')->default(true);
            $table->unique(['company_id','code']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_business_calendars');
    }
};
