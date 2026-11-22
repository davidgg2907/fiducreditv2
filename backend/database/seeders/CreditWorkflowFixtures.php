<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class CreditWorkflowFixtures
{
    public static function id(string $name): string
    {
        $hex = md5('fiducredit-v2-workflow-'.$name);
        return substr($hex, 0, 8).'-'.substr($hex, 8, 4).'-4'.substr($hex, 13, 3).'-8'.substr($hex, 17, 3).'-'.substr($hex, 20, 12);
    }

    public static function role(string $name): int
    {
        $existing = DB::table('roles')->where('name', $name)->value('id');
        if ($existing !== null) return (int) $existing;
        return (int) DB::table('roles')->insertGetId([
            'name' => $name,
            'permissions' => json_encode(['inicio.ver', 'perfil.ver', 'perfil.editar']),
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    public static function seed(string $table, array $rows): void
    {
        foreach ($rows as $row) {
            $row = ['created_at' => now(), 'updated_at' => now()] + $row;
            // Event history is intentionally append-only at the application layer.
            if ($table === 'credit_workflow_task_history') {
                DB::table($table)->insertOrIgnore($row);
            } else {
                DB::table($table)->updateOrInsert(['id' => $row['id']], $row);
            }
        }
    }

    public static function rows(string $table): array
    {
        $id = fn (string $v): string => self::id($v);
        $company = CreditOriginacionFixtures::id('credit_companies');
        $product = CreditOriginacionFixtures::id('credit_products');
        $application = CreditOriginacionFixtures::id('credit_applications');
        $branch = CreditOriginacionFixtures::id('credit_branches');
        $user = CreditOriginacionFixtures::userId();
        $workflow = $id('workflow.personal-nomina');
        $version = $id('workflow.personal-nomina.v1');
        $step = fn (string $v): string => $id('step.'.$v);
        $transition = fn (string $v): string => $id('transition.'.$v);
        $task = $id('task.capture.initial');

        return match ($table) {
            'credit_workflows' => [[
                'id' => $workflow, 'company_id' => $company, 'product_id' => $product,
                'code' => 'ORIG-PERSONAL-NOMINA', 'name' => 'Originación de crédito personal con nómina',
                'description' => 'Captura, mesa de control documental, análisis, autorización y dictamen.',
                'enabled' => true, 'created_by' => $user,
            ]],
            'credit_workflow_versions' => [[
                'id' => $version, 'workflow_id' => $workflow, 'version' => 1,
                'status' => 'published', 'is_default' => true,
                'published_at' => '2026-11-21 10:00:00', 'retired_at' => null,
                'published_by' => $user, 'configuration_hash' => hash('sha256', 'orig-personal-nomina-v1'),
            ]],
            'credit_workflow_steps' => [
                ['id' => $step('capture'), 'workflow_version_id' => $version, 'code' => 'CAPTURA', 'name' => 'Captura de solicitud', 'step_type' => 'manual', 'application_status' => 'captured', 'application_substatus' => null, 'sort_order' => 10, 'is_initial' => true, 'is_terminal' => false, 'allow_manual_assignment' => true, 'metadata' => json_encode(['responsable' => 'Asesor de crédito'])],
                ['id' => $step('documents'), 'workflow_version_id' => $version, 'code' => 'MESA_CONTROL', 'name' => 'Mesa de control documental', 'step_type' => 'manual', 'application_status' => 'under_review', 'application_substatus' => 'document_validation', 'sort_order' => 20, 'is_initial' => false, 'is_terminal' => false, 'allow_manual_assignment' => true, 'metadata' => json_encode(['responsable' => 'Mesa de control'])],
                ['id' => $step('analysis'), 'workflow_version_id' => $version, 'code' => 'ANALISIS', 'name' => 'Análisis de crédito', 'step_type' => 'manual', 'application_status' => 'under_review', 'application_substatus' => 'credit_analysis', 'sort_order' => 30, 'is_initial' => false, 'is_terminal' => false, 'allow_manual_assignment' => true, 'metadata' => null],
                ['id' => $step('authorization'), 'workflow_version_id' => $version, 'code' => 'AUTORIZACION', 'name' => 'Autorización crediticia', 'step_type' => 'manual', 'application_status' => 'under_review', 'application_substatus' => 'authorization', 'sort_order' => 40, 'is_initial' => false, 'is_terminal' => false, 'allow_manual_assignment' => true, 'metadata' => null],
                ['id' => $step('approved'), 'workflow_version_id' => $version, 'code' => 'APROBADA', 'name' => 'Solicitud aprobada', 'step_type' => 'terminal', 'application_status' => 'approved', 'application_substatus' => null, 'sort_order' => 50, 'is_initial' => false, 'is_terminal' => true, 'allow_manual_assignment' => false, 'metadata' => null],
                ['id' => $step('rejected'), 'workflow_version_id' => $version, 'code' => 'RECHAZADA', 'name' => 'Solicitud rechazada', 'step_type' => 'terminal', 'application_status' => 'rejected', 'application_substatus' => null, 'sort_order' => 60, 'is_initial' => false, 'is_terminal' => true, 'allow_manual_assignment' => false, 'metadata' => null],
            ],
            'credit_workflow_transitions' => array_map(fn ($entry) => [
                'id' => $transition($entry[0]), 'workflow_version_id' => $version,
                'from_step_id' => $step($entry[1]), 'to_step_id' => $step($entry[2]),
                'code' => strtoupper($entry[0]), 'name' => $entry[3], 'action' => $entry[4],
                'requires_reason' => $entry[5], 'requires_authorization' => $entry[6], 'enabled' => true,
            ], [
                ['send_to_control', 'capture', 'documents', 'Enviar a mesa de control', 'submit', false, false],
                ['send_to_analysis', 'documents', 'analysis', 'Enviar a análisis crediticio', 'advance', false, false],
                ['return_to_advisor', 'documents', 'capture', 'Devolver al asesor por documentos', 'return', true, false],
                ['send_to_authorization', 'analysis', 'authorization', 'Enviar a autorización', 'advance', false, false],
                ['return_for_correction', 'analysis', 'capture', 'Solicitar corrección de datos', 'return', true, false],
                ['approve_credit', 'authorization', 'approved', 'Aprobar solicitud', 'approve', true, true],
                ['reject_credit', 'authorization', 'rejected', 'Rechazar solicitud', 'reject', true, true],
            ]),
            'credit_workflow_step_roles' => [
                ['id' => $id('role.capture.advisor'), 'step_id' => $step('capture'), 'role_id' => self::role('Asesor de Crédito'), 'can_view' => true, 'can_claim' => true, 'can_process' => true, 'can_assign' => false],
                ['id' => $id('role.documents.control'), 'step_id' => $step('documents'), 'role_id' => self::role('Mesa de Control de Crédito'), 'can_view' => true, 'can_claim' => true, 'can_process' => true, 'can_assign' => true],
                ['id' => $id('role.analysis.analyst'), 'step_id' => $step('analysis'), 'role_id' => self::role('Analista de Crédito'), 'can_view' => true, 'can_claim' => true, 'can_process' => true, 'can_assign' => false],
                ['id' => $id('role.authorization.authorizer'), 'step_id' => $step('authorization'), 'role_id' => self::role('Autorizador de Crédito'), 'can_view' => true, 'can_claim' => true, 'can_process' => true, 'can_assign' => true],
            ],
            'credit_workflow_step_rules' => [
                ['id' => $id('rule.capture.required_fields'), 'step_id' => $step('capture'), 'transition_id' => $transition('send_to_control'), 'code' => 'CAMPOS_OBLIGATORIOS', 'rule_type' => 'required_fields', 'operator' => 'all', 'parameters' => json_encode(['fields' => ['client_id','requested_amount','address_version_id','product_version_id']]), 'blocking' => true, 'enabled' => true],
                ['id' => $id('rule.documents.validated'), 'step_id' => $step('documents'), 'transition_id' => $transition('send_to_analysis'), 'code' => 'DOCUMENTOS_VALIDOS', 'rule_type' => 'required_documents', 'operator' => 'all', 'parameters' => json_encode(['source' => 'credit_product_documents', 'required_status' => 'validated']), 'blocking' => true, 'enabled' => true],
                ['id' => $id('rule.analysis.dti'), 'step_id' => $step('analysis'), 'transition_id' => $transition('send_to_authorization'), 'code' => 'FACTOR_DTI', 'rule_type' => 'financial_threshold', 'operator' => '<=', 'parameters' => json_encode(['metric' => 'debt_to_income_ratio','source' => 'credit_product_versions.max_dti']), 'blocking' => true, 'enabled' => true],
                ['id' => $id('rule.authorization.dictamen'), 'step_id' => $step('authorization'), 'transition_id' => $transition('approve_credit'), 'code' => 'DICTAMEN_REQUERIDO', 'rule_type' => 'approval_documented', 'operator' => 'exists', 'parameters' => json_encode(['record' => 'credit_application_analyses','status' => 'completed']), 'blocking' => true, 'enabled' => true],
            ],
            'credit_workflow_instances' => [[
                'id' => $id('instance.application.demo'), 'application_id' => $application,
                'workflow_version_id' => $version, 'current_step_id' => $step('capture'),
                'status' => 'running', 'started_at' => '2026-11-21 12:00:00',
                'completed_at' => null, 'started_by' => $user, 'lock_version' => 0,
            ]],
            'credit_workflow_tasks' => [[
                'id' => $task, 'instance_id' => $id('instance.application.demo'),
                'step_id' => $step('capture'), 'branch_id' => $branch,
                'assigned_to' => $user, 'assigned_role_id' => self::role('Asesor de Crédito'),
                'task_type' => 'capture', 'status' => 'pending', 'priority' => 3,
                'due_at' => '2026-11-23 18:00:00', 'assigned_at' => '2026-11-21 12:00:00',
                'started_at' => null, 'finished_at' => null, 'resolution_notes' => null,
            ]],
            'credit_workflow_task_history' => [[
                'id' => $id('history.capture.assigned'), 'task_id' => $task,
                'actor_id' => $user, 'event_type' => 'assigned', 'from_status' => null,
                'to_status' => 'pending', 'previous_assignee' => null, 'new_assignee' => $user,
                'reason' => 'Asignación inicial al asesor que registró la solicitud',
                'details' => json_encode(['application_number' => 'SOL-MTY-2026-000042']),
                'occurred_at' => '2026-11-21 12:00:00',
            ]],
            'credit_workflow_sla' => [
                ['id' => $id('sla.capture'), 'step_id' => $step('capture'), 'target_minutes' => 480, 'warning_minutes' => 360, 'escalation_minutes' => 600, 'calendar_type' => 'business_hours', 'timezone' => 'America/Monterrey', 'escalation_role_id' => self::role('Mesa de Control de Crédito'), 'enabled' => true],
                ['id' => $id('sla.documents'), 'step_id' => $step('documents'), 'target_minutes' => 240, 'warning_minutes' => 180, 'escalation_minutes' => 300, 'calendar_type' => 'business_hours', 'timezone' => 'America/Monterrey', 'escalation_role_id' => self::role('Mesa de Control de Crédito'), 'enabled' => true],
                ['id' => $id('sla.analysis'), 'step_id' => $step('analysis'), 'target_minutes' => 480, 'warning_minutes' => 360, 'escalation_minutes' => 600, 'calendar_type' => 'business_hours', 'timezone' => 'America/Monterrey', 'escalation_role_id' => self::role('Autorizador de Crédito'), 'enabled' => true],
                ['id' => $id('sla.authorization'), 'step_id' => $step('authorization'), 'target_minutes' => 240, 'warning_minutes' => 180, 'escalation_minutes' => 300, 'calendar_type' => 'business_hours', 'timezone' => 'America/Monterrey', 'escalation_role_id' => self::role('Autorizador de Crédito'), 'enabled' => true],
            ],
            default => throw new \InvalidArgumentException("Tabla desconocida: {$table}"),
        };
    }
}
