<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_business_holidays', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('calendar_id')->constrained('credit_business_calendars')->restrictOnDelete();
            $table->date('holiday_date');
            $table->string('description',150);
            $table->boolean('recurring')->default(false);
            $table->unique(['calendar_id','holiday_date']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_business_holidays');
    }
};
