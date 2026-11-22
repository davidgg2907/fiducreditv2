<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('code',60);
            $table->string('name',160);
            $table->string('regulatory_regime',60);
            $table->boolean('enabled')->default(true);
            $table->unique(['company_id','code']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_policies');
    }
};
