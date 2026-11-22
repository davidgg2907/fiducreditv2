<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_product_calendars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->unique()->constrained('credit_product_versions')->restrictOnDelete();
            $table->foreignUuid('calendar_id')->constrained('credit_business_calendars')->restrictOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('credit_product_calendars');
    }
};
