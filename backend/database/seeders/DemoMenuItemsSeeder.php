<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DemoMenuItemsSeeder extends Seeder
{
    public function run(): void
    {
        $group = [
            'code' => 'demo_gestion_personal',
            'label' => 'Gestión de personal',
            'icon' => 'groups',
            'position' => 30,
            'parent_id' => null,
            'module_action_id' => null,
            'route' => null,
        ];
        DB::table('menu_items')->upsert([$group], ['code'], ['label', 'icon', 'position', 'parent_id', 'module_action_id', 'route']);

        $groupId = DB::table('menu_items')->where('code', $group['code'])->value('id');
        $actions = DB::table('module_actions')
            ->whereIn('permission', ['demo_panel_personal.ver', 'demo_autoservicio.ver'])
            ->pluck('id', 'permission');

        DB::table('menu_items')->upsert([
            [
                'code' => 'demo_panel_personal',
                'label' => 'Panel de personal',
                'route' => '/home',
                'icon' => 'dashboard',
                'position' => 10,
                'parent_id' => $groupId,
                'module_action_id' => $actions['demo_panel_personal.ver'],
            ],
            [
                'code' => 'demo_autoservicio',
                'label' => 'Autoservicio de personal',
                'route' => '/perfil',
                'icon' => 'badge',
                'position' => 20,
                'parent_id' => $groupId,
                'module_action_id' => $actions['demo_autoservicio.ver'],
            ],
        ], ['code'], ['label', 'route', 'icon', 'position', 'parent_id', 'module_action_id']);
    }
}
