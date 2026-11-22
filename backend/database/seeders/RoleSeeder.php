<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

final class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Usuario'], [
            'permissions' => ['inicio.ver', 'perfil.ver', 'perfil.editar'],
        ]);
    }
}
