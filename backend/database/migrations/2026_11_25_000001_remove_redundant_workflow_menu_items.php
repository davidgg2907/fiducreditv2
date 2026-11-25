<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menu_items')->whereIn('code', [
            'credit_configuracion-sistema_etapas_flujos',
            'credit_configuracion-sistema_reglas_flujos',
            'credit_configuracion-sistema_roles_flujos',
        ])->delete();
    }

    public function down(): void
    {
        $parent = DB::table('menu_items')->where('code', 'credit_configuracion-sistema_'.substr(hash('sha256', 'Flujos de trabajo'), 0, 12))->value('id');
        if (!$parent) return;
        foreach ([
            ['etapas_flujos', 'Etapas y transiciones', 'alt_route', 20],
            ['reglas_flujos', 'Reglas de flujo', 'rule', 30],
            ['roles_flujos', 'Roles por etapa', 'verified_user', 40],
        ] as [$key, $label, $icon, $position]) {
            $code = 'credit_configuracion-sistema_'.$key;
            $action = DB::table('module_actions')->where('permission', $code.'.ver')->value('id');
            if (!$action) continue;
            DB::table('menu_items')->updateOrInsert(['code' => $code], [
                'label' => $label, 'route' => '/'.$key, 'icon' => $icon,
                'parent_id' => $parent, 'module_action_id' => $action,
                'app_code' => 'configuracion-sistema', 'position' => $position,
            ]);
        }
    }
};
