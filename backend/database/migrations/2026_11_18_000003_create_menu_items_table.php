<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->foreignId('module_action_id')->nullable()->constrained()->restrictOnDelete();
            $table->string('label', 100);
            $table->string('route')->nullable();
            $table->string('icon', 80)->nullable();
            $table->unsignedInteger('position')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
