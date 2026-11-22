<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DemoModuleActionsSeeder extends Seeder
{
    public function run(): void
    {
        $modules = DB::table('access_modules')
            ->whereIn('code', ['demo_panel_personal', 'demo_autoservicio'])
            ->pluck('id', 'code');

        DB::table('module_actions')->upsert([
            ['module_id' => $modules['demo_panel_personal'], 'permission' => 'demo_panel_personal.ver', 'name' => 'Ver panel de personal'],
            ['module_id' => $modules['demo_panel_personal'], 'permission' => 'demo_panel_personal.revisar', 'name' => 'Revisar indicadores de personal'],
            ['module_id' => $modules['demo_autoservicio'], 'permission' => 'demo_autoservicio.ver', 'name' => 'Ver autoservicio de personal'],
        ], ['permission'], ['module_id', 'name']);
    }
}
