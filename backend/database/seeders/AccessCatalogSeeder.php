<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class AccessCatalogSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            DB::table('access_modules')->upsert([
                ['code' => 'inicio', 'name' => 'Inicio'],
                ['code' => 'perfil', 'name' => 'Mi perfil'],
            ], ['code'], ['name']);

            $modules = DB::table('access_modules')->whereIn('code', ['inicio', 'perfil'])->pluck('id', 'code');

            DB::table('module_actions')->upsert([
                ['module_id' => $modules['inicio'], 'permission' => 'inicio.ver', 'name' => 'Ver inicio'],
                ['module_id' => $modules['perfil'], 'permission' => 'perfil.ver', 'name' => 'Ver perfil'],
                ['module_id' => $modules['perfil'], 'permission' => 'perfil.editar', 'name' => 'Editar perfil propio'],
            ], ['permission'], ['module_id', 'name']);

            DB::table('menu_items')->upsert([
                ['code' => 'inicio', 'label' => 'Inicio', 'route' => '/home', 'icon' => 'dashboard', 'position' => 10],
                ['code' => 'perfil', 'label' => 'Mi perfil', 'route' => '/perfil', 'icon' => 'person', 'position' => 20],
            ], ['code'], ['label', 'route', 'icon', 'position']);
        });
    }
}
