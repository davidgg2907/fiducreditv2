<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('auth_login_history', function(Blueprint $t){
   $t->bigIncrements('id'); $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
   $t->string('user_name'); $t->string('frontend',40)->nullable(); $t->timestamp('started_at')->index();
  });
  Schema::create('operational_request_logs', function(Blueprint $t){
   $t->bigIncrements('id'); $t->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
   $t->string('frontend',40); $t->string('operation',255); $t->unsignedSmallInteger('http_status');
   $t->timestamp('occurred_at'); $t->index(['frontend','occurred_at']);
  });
 }
 public function down(): void { Schema::dropIfExists('operational_request_logs'); Schema::dropIfExists('auth_login_history'); }
};