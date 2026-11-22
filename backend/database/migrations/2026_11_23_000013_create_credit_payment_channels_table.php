<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_payment_channels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('code',50);
            $table->string('name',100);
            $table->string('channel_type',40);
            $table->boolean('cash_allowed')->default(false);
            $table->boolean('enabled')->default(true);
            $table->unique(['company_id','code']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_payment_channels');
    }
};
