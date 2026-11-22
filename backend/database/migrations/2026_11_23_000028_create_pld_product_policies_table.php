<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_product_policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->foreignUuid('policy_version_id')->constrained('pld_policy_versions')->restrictOnDelete();
            $table->boolean('enabled')->default(true);
            $table->unique(['product_version_id','policy_version_id'],'pld_product_policy_version_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_product_policies');
    }
};
