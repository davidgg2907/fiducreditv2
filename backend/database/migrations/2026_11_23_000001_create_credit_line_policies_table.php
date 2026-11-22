<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_line_policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_version_id')->constrained('credit_product_versions')->restrictOnDelete();
            $table->string('line_type',30)->default('non_revolving');
            $table->boolean('replenish_principal')->default(false);
            $table->unsignedSmallInteger('max_simultaneous_loans')->default(1);
            $table->decimal('max_utilization_pct',9,6)->default(1);
            $table->decimal('min_draw_amount',18,2)->default(0);
            $table->boolean('require_new_approval_per_draw')->default(true);
            $table->boolean('enabled')->default(true);
            $table->unique('product_version_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_line_policies');
    }
};
