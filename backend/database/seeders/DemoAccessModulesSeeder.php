<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DemoAccessModulesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('access_modules')->upsert([
            ['code' => 'demo_panel_personal', 'name' => 'Panel de personal'],
            ['code' => 'demo_autoservicio', 'name' => 'Autoservicio de personal'],
        ], ['code'], ['name']);
    }
}
