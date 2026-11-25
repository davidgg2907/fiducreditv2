<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('credit_product_versions', function (Blueprint $table) {
            $table->json('product_snapshot')->nullable();
            $table->string('changed_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('credit_product_versions', function (Blueprint $table) {
            $table->dropColumn(['product_snapshot', 'changed_by']);
        });
    }
};
