<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // NULL for ordinary users. The database accepts a single bootstrap superadmin.
            $table->boolean('is_superadmin')->nullable()->unique();
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->text('mfa_secret')->nullable();
            $table->unsignedBigInteger('mfa_last_step')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['is_superadmin']);
            $table->dropConstrainedForeignId('role_id');
            $table->dropColumn(['is_superadmin', 'mfa_secret', 'mfa_last_step']);
        });
    }
};
