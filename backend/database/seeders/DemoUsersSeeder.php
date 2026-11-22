<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DemoUsersSeeder extends Seeder
{
    public function run(string $password): void
    {
        $roles = Role::whereIn('name', [
            DemoRolesSeeder::COORDINACION,
            DemoRolesSeeder::ANALISTA,
            DemoRolesSeeder::COLABORADOR,
        ])->pluck('id', 'name');

        foreach ([
            ['Mariana Salgado Ríos', 'mariana.salgado@arquetipo.test', DemoRolesSeeder::COORDINACION],
            ['Diego Valdés Herrera', 'diego.valdes@arquetipo.test', DemoRolesSeeder::ANALISTA],
            ['Elena Cortés Medina', 'elena.cortes@arquetipo.test', DemoRolesSeeder::COLABORADOR],
        ] as [$name, $email, $role]) {
            User::unguarded(fn () => User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'password' => $password,
                'role_id' => $roles[$role],
            ]));
        }
    }
}
