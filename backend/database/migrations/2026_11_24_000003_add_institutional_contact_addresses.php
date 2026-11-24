<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['credit_companies', 'credit_branches', 'credit_advisors'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table): void {
                $blueprint->string('street', 255)->nullable();
                $blueprint->string('neighborhood', 180)->nullable();
                $blueprint->string('city', 180)->nullable();
                $blueprint->string('postal_code', 5)->nullable();
                if ($table !== 'credit_branches') {
                    $blueprint->string('state', 180)->nullable();
                    $blueprint->string('municipality', 180)->nullable();
                }
            });
        }
        Schema::table('credit_advisors', function (Blueprint $table): void {
            $table->string('full_name', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->boolean('has_system_access')->default(false);
        });
        Schema::table('credit_advisors', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
        \Illuminate\Support\Facades\DB::table('credit_advisors')->whereNotNull('user_id')->update(['has_system_access' => true]);
    }
    public function down(): void
    {
        Schema::table('credit_advisors', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
        });
        // Para revertir una cuenta sin usuario primero se requiere corregir los datos.
        if (\Illuminate\Support\Facades\DB::table('credit_advisors')->whereNull('user_id')->exists()) {
            throw new \RuntimeException('No se puede revertir: existen asesores sin cuenta de usuario.');
        }
        Schema::table('credit_advisors', function (Blueprint $table): void {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->dropColumn(['full_name','phone','contact_email','has_system_access']);
        });
        foreach (['credit_companies', 'credit_branches', 'credit_advisors'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table): void {
                $columns = ['street','neighborhood','city','postal_code'];
                if ($table !== 'credit_branches') $columns = array_merge($columns, ['state','municipality']);
                $blueprint->dropColumn($columns);
            });
        }
    }
};
