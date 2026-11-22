<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

final class CreditAdministrationFixtures
{
    public static function id(string $key): string
    {
        $hex = md5('fiducredit-v2-cartera-demo-'.$key);
        return substr($hex, 0, 8).'-'.substr($hex, 8, 4).'-4'.substr($hex, 13, 3).'-8'.substr($hex, 17, 3).'-'.substr($hex, 20, 12);
    }

    // An independent APPROVED test application; the original CAPTURED example is preserved.
    public static function prepareApprovedApplication(): void
    {
        $application = CreditOriginacionFixtures::rows('credit_applications');
        $application['id'] = self::id('approved_application');
        $application['application_number'] = 'SOL-MTY-2026-000051';
        $application['version'] = 1;
        $application['requested_amount'] = 25000;
        $application['approved_amount'] = 25000;
        $application['requested_term'] = 6;
        $application['status'] = 'approved';
        $application['review_substatus'] = null;
        $application['submitted_at'] = '2026-11-18 10:00:00';
        $application['decided_at'] = '2026-11-20 09:30:00';
        $application['product_snapshot'] = json_encode(['product_code' => 'PERSONAL-NOMINA', 'version' => 1, 'simulation' => true]);
        $application['created_at'] = now();
        $application['updated_at'] = now();
        DB::table('credit_applications')->updateOrInsert(['id' => $application['id']], $application);

        $conditions = CreditOriginacionFixtures::rows('credit_application_conditions');
        $conditions['id'] = self::id('approved_application.conditions');
        $conditions['application_id'] = $application['id'];
        $conditions['approved_term'] = 6;
        $conditions['conditions_accepted_at'] = '2026-11-20 09:40:00';
        $conditions['created_at'] = now();
        $conditions['updated_at'] = now();
        DB::table('credit_application_conditions')->updateOrInsert(['id' => $conditions['id']], $conditions);

        $decision = CreditOriginacionFixtures::rows('credit_application_decisions');
        $decision['id'] = self::id('approved_application.decision');
        $decision['application_id'] = $application['id'];
        $decision['decision'] = 'approved';
        $decision['approved_amount'] = 25000;
        $decision['reason'] = 'Autorización ficticia para pruebas de administración de cartera';
        $decision['decided_at'] = '2026-11-20 09:30:00';
        $decision['created_at'] = now();
        $decision['updated_at'] = now();
        DB::table('credit_application_decisions')->updateOrInsert(['id' => $decision['id']], $decision);

        // Keep historical evidence for the separate approved simulation.
        DB::table('credit_application_status_history')->insertOrIgnore([
            'id' => self::id('approved_application.history'),
            'application_id' => $application['id'],
            'from_status' => 'under_review',
            'to_status' => 'approved',
            'from_substatus' => 'authorization',
            'to_substatus' => null,
            'reason' => 'Aprobación de ejemplo ficticio',
            'changed_by' => CreditOriginacionFixtures::userId(),
            'changed_at' => '2026-11-20 09:30:00',
        ]);

        // Link the final workflow version if the workflow fixtures have been loaded.
        if (DB::table('credit_workflow_versions')->where('id', CreditWorkflowFixtures::id('workflow.personal-nomina.v1'))->exists()) {
            $row = [
                'id' => self::id('approved_application.workflow_instance'),
                'application_id' => $application['id'],
                'workflow_version_id' => CreditWorkflowFixtures::id('workflow.personal-nomina.v1'),
                'current_step_id' => CreditWorkflowFixtures::id('step.approved'),
                'status' => 'completed',
                'started_at' => '2026-11-18 10:00:00',
                'completed_at' => '2026-11-20 09:30:00',
                'started_by' => CreditOriginacionFixtures::userId(),
                'lock_version' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ];
            DB::table('credit_workflow_instances')->updateOrInsert(['id' => $row['id']], $row);
        }
    }

    public static function rows(string $table): array
    {
        $fixtures = json_decode(<<<'JSON'
{
  "credit_line_policies": [
    {
      "product_version_id": "@origin:credit_product_versions",
      "line_type": "non_revolving",
      "replenish_principal": false,
      "max_simultaneous_loans": 1,
      "max_utilization_pct": 1,
      "min_draw_amount": 1000,
      "require_new_approval_per_draw": true,
      "enabled": true
    }
  ],
  "credit_lines": [
    {
      "company_id": "@origin:credit_companies",
      "client_id": "@origin:credit_clients",
      "origin_application_id": "@approved_application",
      "product_version_id": "@origin:credit_product_versions",
      "policy_id": "@ref:credit_line_policies",
      "line_number": "LIN-MTY-2026-000051",
      "status": "active",
      "currency": "MXN",
      "authorized_limit": 25000,
      "committed_amount": 12000,
      "outstanding_principal": 12000,
      "available_amount": 13000,
      "effective_date": "2026-11-20",
      "expiration_date": "2027-05-20",
      "authorized_by": "@user",
      "authorized_at": "2026-11-20 10:00:00",
      "lock_version": 0
    }
  ],
  "credit_line_limit_history": [
    {
      "line_id": "@ref:credit_lines",
      "previous_limit": 0,
      "new_limit": 25000,
      "reason": "Autorización inicial de línea de crédito",
      "source_application_id": "@approved_application",
      "authorized_by": "@user",
      "effective_at": "2026-11-20 10:00:00"
    }
  ],
  "credit_line_movements": [
    {
      "line_id": "@ref:credit_lines",
      "movement_type": "disbursement",
      "amount": 12000,
      "available_before": 25000,
      "available_after": 13000,
      "loan_id": "@ref:credit_loans",
      "reference": "LINMOV-2026-000051",
      "value_date": "2026-11-20",
      "recorded_at": "2026-11-20 11:00:00",
      "created_by": "@user",
      "metadata": {
        "simulation": true,
        "draw_number": "DISP-MTY-2026-000017"
      }
    }
  ],
  "credit_drawdowns": [
    {
      "line_id": "@ref:credit_lines",
      "application_id": "@approved_application",
      "bank_account_id": "@origin:credit_client_bank_accounts",
      "draw_number": "DISP-MTY-2026-000017",
      "amount": 12000,
      "status": "executed",
      "value_date": "2026-11-20",
      "executed_at": "2026-11-20 11:00:00",
      "external_reference": "SIMULADO-SIN-TRANSFERENCIA-REAL",
      "requested_by": "@user",
      "authorized_by": "@user"
    }
  ],
  "credit_contracts": [
    {
      "line_id": "@ref:credit_lines",
      "application_id": "@approved_application",
      "contract_number": "CONT-MTY-2026-000051",
      "document_version": "2026-01",
      "storage_disk": null,
      "storage_path": null,
      "sha256": null,
      "signed_at": "2026-11-20 10:30:00",
      "status": "simulated",
      "signer_snapshot": {
        "name": "Lucía Fernanda Salazar Morales",
        "simulation": true
      }
    }
  ],
  "credit_loans": [
    {
      "line_id": "@ref:credit_lines",
      "drawdown_id": "@ref:credit_drawdowns",
      "application_id": "@approved_application",
      "contract_id": "@ref:credit_contracts",
      "loan_number": "CRE-MTY-2026-000017",
      "status": "active",
      "currency": "MXN",
      "original_principal": 12000,
      "principal_outstanding": 12000,
      "start_date": "2026-11-20",
      "maturity_date": "2027-05-20",
      "term_count": 6,
      "term_unit": "month",
      "last_accrual_date": "2026-11-21",
      "closed_at": null,
      "lock_version": 0
    }
  ],
  "credit_loan_terms": [
    {
      "loan_id": "@ref:credit_loans",
      "version": 1,
      "interest_rate_type": "fixed",
      "ordinary_annual_rate": 0.28,
      "default_annual_rate": 0.36,
      "day_count_convention": "30E_360",
      "amortization_method": "french",
      "payment_frequency": "monthly",
      "interest_calculation": "outstanding_balance",
      "rounding_mode": "half_up",
      "grace_days": 0,
      "tax_on_interest": false,
      "tax_rate": 0,
      "valid_from": "2026-11-20",
      "valid_to": null,
      "terms_snapshot": {
        "approved_term": 6,
        "simulation": true
      }
    }
  ],
  "credit_amortization_schedules": [
    {
      "loan_id": "@ref:credit_loans",
      "terms_id": "@ref:credit_loan_terms",
      "version": 1,
      "status": "active",
      "calculation_date": "2026-11-20",
      "first_due_date": "2026-12-20",
      "scheduled_principal": 12000,
      "scheduled_interest": 998.83,
      "scheduled_total": 12998.83,
      "reason": "Tabla inicial de amortización para crédito de prueba",
      "generated_by": "@user"
    }
  ],
  "credit_amortization_installments": [
    {
      "_key": "installment.1",
      "schedule_id": "@ref:credit_amortization_schedules",
      "loan_id": "@ref:credit_loans",
      "installment_number": 1,
      "period_start": "2026-11-20",
      "due_date": "2026-12-20",
      "opening_principal": 12000,
      "principal_due": 1886.47,
      "ordinary_interest_due": 280,
      "tax_due": 0,
      "fee_due": 0,
      "scheduled_total": 2166.47,
      "closing_principal": 10113.53,
      "principal_paid": 0,
      "interest_paid": 0,
      "tax_paid": 0,
      "fee_paid": 0,
      "status": "pending"
    },
    {
      "_key": "installment.2",
      "schedule_id": "@ref:credit_amortization_schedules",
      "loan_id": "@ref:credit_loans",
      "installment_number": 2,
      "period_start": "2026-12-20",
      "due_date": "2027-01-20",
      "opening_principal": 10113.53,
      "principal_due": 1930.49,
      "ordinary_interest_due": 235.98,
      "tax_due": 0,
      "fee_due": 0,
      "scheduled_total": 2166.47,
      "closing_principal": 8183.04,
      "principal_paid": 0,
      "interest_paid": 0,
      "tax_paid": 0,
      "fee_paid": 0,
      "status": "pending"
    },
    {
      "_key": "installment.3",
      "schedule_id": "@ref:credit_amortization_schedules",
      "loan_id": "@ref:credit_loans",
      "installment_number": 3,
      "period_start": "2027-01-20",
      "due_date": "2027-02-20",
      "opening_principal": 8183.04,
      "principal_due": 1975.53,
      "ordinary_interest_due": 190.94,
      "tax_due": 0,
      "fee_due": 0,
      "scheduled_total": 2166.47,
      "closing_principal": 6207.51,
      "principal_paid": 0,
      "interest_paid": 0,
      "tax_paid": 0,
      "fee_paid": 0,
      "status": "pending"
    },
    {
      "_key": "installment.4",
      "schedule_id": "@ref:credit_amortization_schedules",
      "loan_id": "@ref:credit_loans",
      "installment_number": 4,
      "period_start": "2027-02-20",
      "due_date": "2027-03-20",
      "opening_principal": 6207.51,
      "principal_due": 2021.63,
      "ordinary_interest_due": 144.84,
      "tax_due": 0,
      "fee_due": 0,
      "scheduled_total": 2166.47,
      "closing_principal": 4185.88,
      "principal_paid": 0,
      "interest_paid": 0,
      "tax_paid": 0,
      "fee_paid": 0,
      "status": "pending"
    },
    {
      "_key": "installment.5",
      "schedule_id": "@ref:credit_amortization_schedules",
      "loan_id": "@ref:credit_loans",
      "installment_number": 5,
      "period_start": "2027-03-20",
      "due_date": "2027-04-20",
      "opening_principal": 4185.88,
      "principal_due": 2068.8,
      "ordinary_interest_due": 97.67,
      "tax_due": 0,
      "fee_due": 0,
      "scheduled_total": 2166.47,
      "closing_principal": 2117.08,
      "principal_paid": 0,
      "interest_paid": 0,
      "tax_paid": 0,
      "fee_paid": 0,
      "status": "pending"
    },
    {
      "_key": "installment.6",
      "schedule_id": "@ref:credit_amortization_schedules",
      "loan_id": "@ref:credit_loans",
      "installment_number": 6,
      "period_start": "2027-04-20",
      "due_date": "2027-05-20",
      "opening_principal": 2117.08,
      "principal_due": 2117.08,
      "ordinary_interest_due": 49.4,
      "tax_due": 0,
      "fee_due": 0,
      "scheduled_total": 2166.48,
      "closing_principal": 0,
      "principal_paid": 0,
      "interest_paid": 0,
      "tax_paid": 0,
      "fee_paid": 0,
      "status": "pending"
    }
  ],
  "credit_interest_accruals": [
    {
      "loan_id": "@ref:credit_loans",
      "terms_id": "@ref:credit_loan_terms",
      "period_start": "2026-11-20",
      "period_end": "2026-11-21",
      "value_date": "2026-11-21",
      "accrual_days": 1,
      "principal_basis": 12000,
      "annual_rate": 0.28,
      "interest_amount": 9.33,
      "tax_amount": 0,
      "calculation_key": "INT-CRE-000017-20261121",
      "reversed": false,
      "calculated_at": "2026-11-21 02:00:00"
    }
  ],
  "credit_penalty_accruals": [],
  "credit_payment_channels": [
    {
      "company_id": "@origin:credit_companies",
      "code": "TRANSFERENCIA_SPEI",
      "name": "Transferencia bancaria SPEI",
      "channel_type": "bank_transfer",
      "cash_allowed": false,
      "enabled": true
    },
    {
      "_key": "payment_channel.cash",
      "company_id": "@origin:credit_companies",
      "code": "CAJA",
      "name": "Caja de sucursal",
      "channel_type": "cash",
      "cash_allowed": true,
      "enabled": true
    }
  ],
  "credit_payments": [
    {
      "loan_id": "@ref:credit_loans",
      "line_id": "@ref:credit_lines",
      "channel_id": "@ref:credit_payment_channels",
      "source_bank_account_id": "@origin:credit_client_bank_accounts",
      "payment_number": "PAG-MTY-2026-000029",
      "external_reference": "SIM-TRANSFERENCIA-PENDIENTE-000029",
      "amount": 1000,
      "currency": "MXN",
      "value_date": "2026-11-21",
      "received_at": "2026-11-21 14:00:00",
      "posted_at": null,
      "status": "received",
      "third_party": false,
      "payer_name": "Lucía Fernanda Salazar Morales",
      "recorded_by": "@user"
    }
  ],
  "credit_payment_allocations": [],
  "credit_loan_ledger_entries": [
    {
      "loan_id": "@ref:credit_loans",
      "payment_id": null,
      "drawdown_id": "@ref:credit_drawdowns",
      "entry_number": "POL-CRE-000017-001",
      "entry_type": "disbursement",
      "component": "principal",
      "direction": "debit",
      "amount": 12000,
      "currency": "MXN",
      "value_date": "2026-11-20",
      "posted_at": "2026-11-20 11:00:00",
      "reversal_of_id": null,
      "idempotency_key": "demo-disbursement-cre-000017",
      "metadata": {
        "simulation": true
      }
    },
    {
      "_key": "ledger.interest.001",
      "loan_id": "@ref:credit_loans",
      "payment_id": null,
      "drawdown_id": null,
      "entry_number": "POL-CRE-000017-002",
      "entry_type": "interest_accrual",
      "component": "ordinary_interest",
      "direction": "debit",
      "amount": 9.33,
      "currency": "MXN",
      "value_date": "2026-11-21",
      "posted_at": "2026-11-21 02:00:00",
      "reversal_of_id": null,
      "idempotency_key": "demo-interest-cre-000017-20261121",
      "metadata": {
        "simulation": true
      }
    }
  ],
  "credit_loan_balances": [
    {
      "loan_id": "@ref:credit_loans",
      "principal_due": 0,
      "ordinary_interest_due": 9.33,
      "penalty_interest_due": 0,
      "tax_due": 0,
      "fee_due": 0,
      "unapplied_payments": 0,
      "total_due": 9.33,
      "as_of_date": "2026-11-21",
      "lock_version": 0
    }
  ],
  "credit_loan_events": [
    {
      "loan_id": "@ref:credit_loans",
      "actor_id": "@user",
      "event_type": "simulated_disbursement",
      "previous_status": "pending_disbursement",
      "new_status": "active",
      "payload": {
        "amount": 12000,
        "simulation": true
      },
      "correlation_id": "SIM-CRE-MTY-000017",
      "occurred_at": "2026-11-20 11:00:00"
    }
  ],
  "credit_payoff_quotes": [
    {
      "loan_id": "@ref:credit_loans",
      "quote_number": "LIQ-CRE-000017-20261121",
      "value_date": "2026-11-21",
      "expires_at": "2026-11-21 23:59:59",
      "principal_amount": 12000,
      "interest_amount": 9.33,
      "penalty_amount": 0,
      "tax_amount": 0,
      "fees_amount": 0,
      "credits_amount": 0,
      "total_to_settle": 12009.33,
      "status": "quoted",
      "generated_by": "@user",
      "calculation_snapshot": {
        "principal": 12000,
        "days_accrued": 1,
        "method": "30E_360",
        "simulation": true
      }
    }
  ],
  "credit_payoff_quote_items": [
    {
      "quote_id": "@ref:credit_payoff_quotes",
      "component": "principal",
      "description": "Capital insoluto",
      "amount": 12000,
      "sort_order": 1
    },
    {
      "_key": "quote.item.interest",
      "quote_id": "@ref:credit_payoff_quotes",
      "component": "ordinary_interest",
      "description": "Interés devengado a fecha valor",
      "amount": 9.33,
      "sort_order": 2
    }
  ],
  "credit_settlements": [],
  "credit_loan_restructures": [],
  "credit_loan_adjustments": [],
  "credit_delinquency_snapshots": [
    {
      "loan_id": "@ref:credit_loans",
      "as_of_date": "2026-11-21",
      "days_past_due": 0,
      "overdue_installments": 0,
      "overdue_principal": 0,
      "overdue_interest": 0,
      "penalty_interest": 0,
      "bucket": "current"
    }
  ],
  "pld_policies": [
    {
      "company_id": "@origin:credit_companies",
      "code": "PLD-CREDITOS-MX",
      "name": "Monitoreo preventivo de operaciones crediticias",
      "regulatory_regime": "to_be_defined_by_entity",
      "enabled": true
    }
  ],
  "pld_policy_versions": [
    {
      "policy_id": "@ref:pld_policies",
      "version": 1,
      "status": "published",
      "effective_from": "2026-11-20",
      "effective_to": null,
      "approved_by": "@user",
      "approved_at": "2026-11-20 09:00:00",
      "monitoring_config": {
        "scope": [
          "disbursement",
          "payment",
          "attempted_payment",
          "settlement"
        ],
        "currency": "MXN",
        "simulation": true,
        "mandatory_regulatory_limits": "not_configured"
      }
    }
  ],
  "pld_rules": [
    {
      "policy_version_id": "@ref:pld_policy_versions",
      "code": "INTENTO_PAGO_ATIPICO",
      "name": "Intento de pago atípico por importe elevado",
      "event_type": "attempted_payment",
      "rule_type": "fixed_internal_threshold",
      "parameters": {
        "minimum_amount": 15000,
        "third_party": true,
        "currency": "MXN",
        "note": "Umbral interno ilustrativo, no umbral legal"
      },
      "severity": "medium",
      "blocking": false,
      "enabled": true
    }
  ],
  "pld_product_policies": [
    {
      "product_version_id": "@origin:credit_product_versions",
      "policy_version_id": "@ref:pld_policy_versions",
      "enabled": true
    }
  ],
  "pld_client_profiles": [
    {
      "client_id": "@origin:credit_clients",
      "policy_version_id": "@ref:pld_policy_versions",
      "risk_level": "medium",
      "occupation": "Analista administrativa",
      "economic_activity": "Servicios administrativos",
      "funds_origin": "Ingresos laborales",
      "expected_monthly_volume": 8000,
      "expected_monthly_operations": 2,
      "residency_country": "MX",
      "pep_declared": false,
      "assessed_at": "2026-11-20 09:00:00",
      "next_review_at": "2027-11-20 09:00:00",
      "assessed_by": "@user"
    }
  ],
  "pld_beneficial_owners": [
    {
      "client_id": "@origin:credit_clients",
      "full_name": "Lucía Fernanda Salazar Morales",
      "relationship": "Titular persona física",
      "ownership_percentage": null,
      "identification_reference": null,
      "verified": false,
      "verified_at": null
    }
  ],
  "pld_screenings": [
    {
      "client_id": "@origin:credit_clients",
      "loan_id": "@ref:credit_loans",
      "screening_type": "sanctions_pep",
      "provider": "Proveedor de listas por configurar",
      "list_version": null,
      "result": "not_run",
      "external_reference": null,
      "evidence_path": null,
      "screened_at": "2026-11-20 09:00:00",
      "reviewed_by": null
    }
  ],
  "pld_monitoring_events": [
    {
      "client_id": "@origin:credit_clients",
      "line_id": "@ref:credit_lines",
      "loan_id": "@ref:credit_loans",
      "payment_id": null,
      "drawdown_id": null,
      "settlement_id": null,
      "policy_version_id": "@ref:pld_policy_versions",
      "event_key": "SIM-ATTEMPTED-PAYMENT-20261121-0001",
      "event_type": "attempted_payment",
      "amount": 20000,
      "currency": "MXN",
      "value_date": "2026-11-21",
      "observed_at": "2026-11-21 15:00:00",
      "facts": {
        "third_party": true,
        "source": "simulated_scenario",
        "linked_real_payment": false
      },
      "evaluation_status": "flagged"
    }
  ],
  "pld_alerts": [
    {
      "monitoring_event_id": "@ref:pld_monitoring_events",
      "rule_id": "@ref:pld_rules",
      "client_id": "@origin:credit_clients",
      "alert_number": "ALR-PLD-SIM-2026-0001",
      "severity": "medium",
      "status": "open",
      "reason": "Intento de pago de tercero por encima de umbral interno ilustrativo; requiere revisión humana",
      "evidence": {
        "simulation": true,
        "not_a_finding_of_illegal_activity": true
      },
      "detected_at": "2026-11-21 15:01:00",
      "assigned_to": "@user",
      "resolved_at": null
    }
  ],
  "pld_alert_actions": [
    {
      "alert_id": "@ref:pld_alerts",
      "actor_id": "@user",
      "action": "assigned_for_review",
      "from_status": null,
      "to_status": "open",
      "notes": "Caso ficticio para demostrar trazabilidad; sin conclusión sobre actividad ilícita",
      "occurred_at": "2026-11-21 15:05:00"
    }
  ],
  "pld_cases": [
    {
      "company_id": "@origin:credit_companies",
      "client_id": "@origin:credit_clients",
      "source_alert_id": "@ref:pld_alerts",
      "case_number": "CASO-PLD-SIM-2026-0001",
      "status": "open",
      "risk_level": "medium",
      "compliance_officer_id": null,
      "opened_at": "2026-11-21 15:05:00",
      "closed_at": null,
      "resolution": null
    }
  ],
  "pld_case_events": [
    {
      "case_id": "@ref:pld_cases",
      "actor_id": "@user",
      "action": "case_opened",
      "notes": "Apertura de caso de prueba por alerta simulada",
      "evidence_path": null,
      "occurred_at": "2026-11-21 15:05:00"
    }
  ],
  "pld_reports": []
}
JSON, true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists($table, $fixtures)) {
            throw new \InvalidArgumentException('Tabla sin fixtures: '.$table);
        }
        $result = [];
        foreach ($fixtures[$table] as $row) {
            $key = $row['_key'] ?? $table;
            unset($row['_key']);
            foreach ($row as $field => $value) {
                if (is_string($value) && str_starts_with($value, '@origin:')) {
                    $row[$field] = CreditOriginacionFixtures::id(substr($value, 8));
                } elseif (is_string($value) && str_starts_with($value, '@ref:')) {
                    $row[$field] = self::id(substr($value, 5));
                } elseif ($value === '@approved_application') {
                    $row[$field] = self::id('approved_application');
                } elseif ($value === '@user') {
                    $row[$field] = CreditOriginacionFixtures::userId();
                } elseif (is_array($value)) {
                    $row[$field] = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
                }
            }
            $result[] = ['id' => self::id($key)] + $row;
        }
        return $result;
    }

    public static function seed(string $table): void
    {
        $withoutTimestamps = ['credit_line_movements', 'credit_loan_ledger_entries', 'credit_loan_events', 'pld_alert_actions', 'pld_case_events'];
        foreach (self::rows($table) as $row) {
            if (!in_array($table, $withoutTimestamps, true)) {
                $row += ['created_at' => now(), 'updated_at' => now()];
            }
            // Repeatable fixtures never add a duplicate audit event.
            DB::table($table)->updateOrInsert(['id' => $row['id']], $row);
        }
    }
}
