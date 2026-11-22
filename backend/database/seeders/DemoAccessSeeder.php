<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class DemoAccessSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local', 'testing')) {
            throw new RuntimeException('Los datos de demostración solo se pueden cargar en local o testing.');
        }

        $password = config('demo_access.password');
        if ($password === null || (is_string($password) && trim($password) === '')) {
            $password = $this->command?->secret('Contraseña para las cuentas demo (mínimo 12 caracteres, máximo 72 bytes)', false);
        }

        if (! is_string($password) || mb_strlen(trim($password)) < 12 || strlen($password) > 72) {
            throw new RuntimeException('Captura una contraseña al ejecutar el seeder o define DEMO_ACCESS_PASSWORD en backend/.env para usar --no-interaction. Debe tener al menos 12 caracteres y un máximo de 72 bytes.');
        }

        DB::transaction(function () use ($password): void {
            $this->call([
                DatabaseSeeder::class,
                DemoAccessModulesSeeder::class,
                DemoModuleActionsSeeder::class,
                DemoMenuItemsSeeder::class,
                DemoRolesSeeder::class,
            ]);

            $this->callWith(DemoUsersSeeder::class, ['password' => $password]);
        }, 3);
    }
}
