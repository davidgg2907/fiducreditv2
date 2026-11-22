<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

final class DemoRolesSeeder extends Seeder
{
    public const COORDINACION = 'Coordinación de Recursos Humanos (demo)';

    public const ANALISTA = 'Analista de personal (demo)';

    public const COLABORADOR = 'Colaborador (demo)';

    public function run(): void
    {
        $base = ['inicio.ver', 'perfil.ver', 'perfil.editar'];

        foreach ([
            self::COORDINACION => ['demo_panel_personal.ver', 'demo_panel_personal.revisar', 'demo_autoservicio.ver'],
            self::ANALISTA => ['demo_panel_personal.ver'],
            self::COLABORADOR => ['demo_autoservicio.ver'],
        ] as $name => $permissions) {
            Role::firstOrCreate(['name' => $name], ['permissions' => [...$base, ...$permissions]]);
        }
    }
}
