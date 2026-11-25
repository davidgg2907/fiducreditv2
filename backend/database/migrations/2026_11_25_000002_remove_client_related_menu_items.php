<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menu_items')->whereIn('code', [
            'credit_originacion_domicilios',
            'credit_originacion_cuentas_bancarias',
        ])->delete();
    }

    public function down(): void
    {
        $parent = DB::table('menu_items')->where('code', 'credit_originacion_'.substr(hash('sha256', 'Clientes y expedientes'), 0, 12))->value('id');
        if (!$parent) return;
        foreach ([
            ['domicilios', 'Domicilios y versiones', 'home', 20],
            ['cuentas_bancarias', 'Cuentas bancarias', 'account_balance', 30],
        ] as [$key, $label, $icon, $position]) {
            $code = 'credit_originacion_'.$key;
            $action = DB::table('module_actions')->where('permission', $code.'.ver')->value('id');
            if (!$action) continue;
            DB::table('menu_items')->updateOrInsert(['code' => $code], [
                'label' => $label, 'route' => '/'.$key, 'icon' => $icon,
                'parent_id' => $parent, 'module_action_id' => $action,
                'app_code' => 'originacion', 'position' => $position,
            ]);
        }
    }
};
