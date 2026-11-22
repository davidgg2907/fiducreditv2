<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('credit_branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('credit_companies')->restrictOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('municipality');
            $table->string('state');
            $table->boolean('active')->default(true);
            $table->unique(['company_id','code']);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('credit_branches'); }
};
