<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pld_beneficial_owners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->constrained('credit_clients')->restrictOnDelete();
            $table->string('full_name',160);
            $table->string('relationship',70);
            $table->decimal('ownership_percentage',7,4)->nullable();
            $table->string('identification_reference')->nullable();
            $table->boolean('verified')->default(false);
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pld_beneficial_owners');
    }
};
