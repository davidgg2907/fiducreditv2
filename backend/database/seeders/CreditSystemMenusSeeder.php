<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Deterministic, repeatable catalog for all five Angular applications.
 * Menu entries point to VIEW/LIST permissions; other actions are for screens and policies.
 * Seeds catalog only: it does not grant permissions to any role.
 */
final class CreditSystemMenusSeeder extends Seeder
{
    private const APPS = [
        'originacion' => [
            'Clientes y expedientes' => [
                ['clientes', 'Clientes', 'people'],
                ['domicilios', 'Domicilios y versiones', 'home'],
                ['cuentas_bancarias', 'Cuentas bancarias', 'account_balance'],
                ['documentos', 'Documentos y validaciones', 'folder'],
                ['expedientes', 'Expedientes', 'description'],
            ],
            'Solicitudes' => [
                ['solicitudes', 'Solicitudes de crédito', 'assignment'],
                ['conceptos_financieros', 'Ingresos y egresos', 'payments'],
                ['consentimientos', 'Consentimientos', 'fact_check'],
                ['obligados_solidarios', 'Obligados solidarios', 'groups'],
            ],
            'Evaluación y decisión' => [
                ['mesa_control', 'Mesa de control', 'rule'],
                ['tareas_originacion', 'Bandeja de tareas', 'task'],
                ['analisis_crediticio', 'Análisis crediticio', 'analytics'],
                ['consultas_buro', 'Consultas de buró', 'manage_search'],
                ['dictamenes', 'Dictámenes y autorizaciones', 'verified'],
            ],
        ],
        'administracion' => [
            'Líneas y contratación' => [
                ['lineas_credito', 'Líneas de crédito', 'account_balance_wallet'],
                ['disposiciones', 'Disposiciones', 'paid'],
                ['contratos', 'Contratos', 'article'],
                ['creditos', 'Créditos activos', 'credit_score'],
            ],
            'Cartera y cálculo' => [
                ['condiciones_credito', 'Condiciones del crédito', 'tune'],
                ['amortizaciones', 'Tablas de amortización', 'table_chart'],
                ['devengos', 'Intereses y devengos', 'calculate'],
                ['mora', 'Mora y vencimientos', 'warning'],
                ['saldos', 'Saldos y movimientos', 'receipt_long'],
            ],
            'Pagos y liquidación' => [
                ['recepcion_pagos', 'Recepción de pagos', 'payments'],
                ['conciliacion', 'Conciliación', 'compare_arrows'],
                ['aplicacion_pagos', 'Aplicación de pagos', 'rule'],
                ['liquidaciones', 'Liquidaciones', 'task_alt'],
                ['reestructuras', 'Reestructuras', 'autorenew'],
                ['ajustes_cartera', 'Ajustes y reversos', 'history'],
            ],
        ],
        'pld-operacion' => [
            'Monitoreo de operaciones' => [
                ['monitoreo_pld', 'Monitoreo transaccional', 'monitor_heart'],
                ['screenings_pld', 'Consultas de listas', 'fact_check'],
                ['alertas_pld', 'Alertas', 'notification_important'],
            ],
            'Investigaciones' => [
                ['casos_pld', 'Casos de investigación', 'folder_shared'],
                ['acciones_alertas_pld', 'Seguimiento de alertas', 'fact_check'],
                ['evidencias_pld', 'Evidencias', 'inventory_2'],
                ['reportes_pld', 'Reportes PLD', 'description'],
            ],
        ],
        'pld-configuracion' => [
            'Políticas y reglas' => [
                ['politicas_pld', 'Políticas PLD', 'policy'],
                ['versiones_politicas_pld', 'Versiones de políticas', 'history'],
                ['reglas_pld', 'Reglas y umbrales', 'tune'],
                ['politicas_producto_pld', 'Políticas por producto', 'account_tree'],
            ],
            'Perfiles e identificación' => [
                ['perfiles_riesgo_pld', 'Perfiles de riesgo', 'person_search'],
                ['beneficiarios_controladores', 'Beneficiarios controladores', 'groups'],
            ],
        ],
        'configuracion-sistema' => [
            'Seguridad y acceso' => [
                ['usuarios', 'Usuarios', 'people'],
                ['roles', 'Roles', 'admin_panel_settings'],
                ['permisos', 'Módulos y acciones', 'key'],
                ['menus', 'Menús por aplicación', 'menu'],
            ],
            'Estructura institucional' => [
                ['empresas', 'Empresas', 'domain'],
                ['sucursales', 'Sucursales', 'store'],
                ['asesores', 'Asesores', 'support_agent'],
            ],
            'Productos y políticas' => [
                ['productos', 'Productos crediticios', 'inventory'],
                ['versiones_productos', 'Versiones de productos', 'history'],
                ['comisiones_productos', 'Comisiones', 'request_quote'],
                ['reglas_productos', 'Reglas de producto', 'rule'],
                ['campos_dinamicos', 'Campos configurables', 'dynamic_form'],
                ['requisitos_documentales', 'Requisitos documentales', 'folder'],
                ['politicas_linea', 'Políticas de líneas', 'account_balance'],
                ['politicas_pago', 'Prioridad de aplicación de pagos', 'format_list_numbered'],
                ['calendarios', 'Calendarios y días inhábiles', 'event'],
            ],
            'Flujos de trabajo' => [
                ['flujos', 'Workflows', 'account_tree'],
                ['etapas_flujos', 'Etapas y transiciones', 'alt_route'],
                ['reglas_flujos', 'Reglas de flujo', 'rule'],
                ['roles_flujos', 'Roles por etapa', 'verified_user'],
                ['sla_flujos', 'SLA y escalamiento', 'schedule'],
            ],
        ],
    ];

    public function run(): void
    {
        DB::transaction(function (): void {
            foreach (self::APPS as $app => $sections) {
                foreach ($sections as $section => $modules) {
                    $sectionCode = 'credit_'.$app.'_'.substr(hash('sha256', $section), 0, 12);
                    DB::table('menu_items')->updateOrInsert(['code' => $sectionCode], [
                        'label' => $section, 'route' => null, 'icon' => 'folder',
                        'parent_id' => null, 'module_action_id' => null,
                        'app_code' => $app, 'position' => 100 + array_search($section, array_keys($sections), true) * 100,
                    ]);
                    $parent = DB::table('menu_items')->where('code', $sectionCode)->value('id');
                    foreach ($modules as $index => [$code, $name, $icon]) {
                        $moduleCode = 'credit_'.$app.'_'.$code;
                        DB::table('access_modules')->updateOrInsert(['code' => $moduleCode], ['name' => $name]);
                        $moduleId = DB::table('access_modules')->where('code', $moduleCode)->value('id');
                        foreach ([
                            'ver' => 'Ver lista o acceder al módulo',
                            'detalle' => 'Ver detalle',
                            'crear' => 'Capturar o crear',
                            'editar' => 'Modificar',
                            'eliminar' => 'Eliminar o dar de baja lógica',
                        ] as $action => $description) {
                            $permission = $moduleCode.'.'.$action;
                            DB::table('module_actions')->updateOrInsert(['permission' => $permission], [
                                'module_id' => $moduleId, 'name' => $description,
                            ]);
                        }
                        $viewId = DB::table('module_actions')->where('permission', $moduleCode.'.ver')->value('id');
                        if (($app === 'configuracion-sistema' && in_array($code, ['etapas_flujos', 'reglas_flujos', 'roles_flujos'], true))
                            || ($app === 'originacion' && in_array($code, ['domicilios', 'cuentas_bancarias'], true))) {
                            DB::table('menu_items')->where('code', $moduleCode)->delete();
                            continue;
                        }
                        DB::table('menu_items')->updateOrInsert(['code' => $moduleCode], [
                            'label' => $name, 'route' => '/'.$code, 'icon' => $icon,
                            'parent_id' => $parent, 'module_action_id' => $viewId,
                            'app_code' => $app, 'position' => ($index + 1) * 10,
                        ]);
                    }
                }
            }
        }, 3);
    }
}
