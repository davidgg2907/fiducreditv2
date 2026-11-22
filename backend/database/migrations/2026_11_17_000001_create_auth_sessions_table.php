<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Existing bearer values were stored verbatim. Invalidate them at cutover.
        DB::table('oauth_refresh_tokens')->delete();
        DB::table('oauth_access_tokens')->delete();

        Schema::create('auth_sessions', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users')->cascadeOnDelete();
            $table->string('access_token_id', 100)->unique();
            $table->boolean('remember');
            $table->timestamp('expires_at');
            $table->timestamp('last_activity_at');
        });
    }

    public function down(): void
    {
        DB::table('oauth_refresh_tokens')->delete();
        DB::table('oauth_access_tokens')->delete();
        Schema::dropIfExists('auth_sessions');
    }
};
