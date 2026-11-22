# API de recursos de FiduCredit V2

**Etapa:** infraestructura CRUD preliminar para 5 frontends, sin reglas de negocio.

**Cobertura:** 83 entidades de dominio; 1 modelo, 1 controlador, 2 requests y 1 response (API Resource) por tabla; un servicio compartido. No se exponen tablas internas de Laravel como sesiones, tokens, caché o colas.

## Contrato

- Base: `/api/v1/credit-clients` (nombres de tablas en kebab-case).
- Listado: `GET /api/v1/credit-clients?per_page=25&filter[company_id]=UUID&include=company`
- Detalle: `GET /api/v1/credit-clients/{uuid}?include=creditApplications`
- Escritura habilitada: `POST`, `PUT`, `PATCH` para tablas que no están marcadas como operativas bloqueadas, exclusivamente para superadministración.
- Borrado: `DELETE` devuelve 405 para preservar evidencia y relaciones.
- Operaciones en créditos, pagos, disposiciones, devengos, contabilidad, casos PLD, reportes, historiales y tareas de workflow: escritura devuelve 405 y requerirá endpoint de caso de uso.
- La lista permite filtros exactos por columna, ordenamiento y paginación hasta 100; includes simples de máximo seis relaciones declaradas.
- Respuesta: `{ "isSuccess": true, "data": ... }`; listados contienen estructura de paginación Laravel.

## Seguridad y límites

- Por ahora **solo superadministrador**. Los usuarios operativos y los cinco frontends todavía necesitan políticas de alcance por empresa/sucursal (no hay mapeo de institución a usuario). No se debe ampliar el acceso hasta implementar autorización multiinstitución.
- Tablas PLD: además de la autenticación, requieren el permiso explícito `pld-data.view` o `pld-data.write` en el rol, sin habilitarlo automáticamente por ser superadministrador.
- Las validaciones iniciales verifican tipos básicos de columnas, pero no todas las restricciones cruzadas. No se ha desarrollado auditoría completa de cambios ni protección selectiva de atributos sensibles: no habilitar escritura operativa en producción.
- Los modelos reflejan las relaciones explícitas del diccionario; las relaciones generadas deben cotejarse con las migraciones antes de su uso productivo.
- Los documentos y datos privados requieren API de almacenamiento seguro específica, no CRUD de rutas.
- Las tablas de productos y versiones publicadas requieren inmutabilidad y publicación formal antes de autorizar uso real.
- El código no contiene motores financieros, lógica de workflow, reglas PLD ni controles regulatorios certificados.

## Recursos generados

- `credit_companies` → `CreditCompanyController` (CRUD parcial sin borrado).
- `credit_branches` → `CreditBranchController` (CRUD parcial sin borrado).
- `credit_advisors` → `CreditAdvisorController` (CRUD parcial sin borrado).
- `credit_products` → `CreditProductController` (CRUD parcial sin borrado).
- `credit_product_versions` → `CreditProductVersionController` (CRUD parcial sin borrado).
- `credit_product_fees` → `CreditProductFeeController` (CRUD parcial sin borrado).
- `credit_product_rules` → `CreditProductRuleController` (CRUD parcial sin borrado).
- `credit_custom_fields` → `CreditCustomFieldController` (CRUD parcial sin borrado).
- `credit_product_fields` → `CreditProductFieldController` (CRUD parcial sin borrado).
- `credit_clients` → `CreditClientController` (CRUD parcial sin borrado).
- `credit_client_addresses` → `CreditClientAddressController` (CRUD parcial sin borrado).
- `credit_client_address_versions` → `CreditClientAddressVersionController` (CRUD parcial sin borrado).
- `credit_client_bank_accounts` → `CreditClientBankAccountController` (CRUD parcial sin borrado).
- `credit_document_types` → `CreditDocumentTypeController` (CRUD parcial sin borrado).
- `credit_document_validation_rules` → `CreditDocumentValidationRuleController` (CRUD parcial sin borrado).
- `credit_product_documents` → `CreditProductDocumentController` (CRUD parcial sin borrado).
- `credit_applications` → `CreditApplicationController` (CRUD parcial sin borrado).
- `credit_application_fields` → `CreditApplicationFieldController` (CRUD parcial sin borrado).
- `credit_application_documents` → `CreditApplicationDocumentController` (CRUD parcial sin borrado).
- `credit_document_checks` → `CreditDocumentCheckController` (solo lectura).
- `credit_application_financial_items` → `CreditApplicationFinancialItemController` (CRUD parcial sin borrado).
- `credit_application_financial_summaries` → `CreditApplicationFinancialSummaryController` (CRUD parcial sin borrado).
- `credit_bureau_inquiries` → `CreditBureauInquiryController` (CRUD parcial sin borrado).
- `credit_application_analyses` → `CreditApplicationAnalyseController` (CRUD parcial sin borrado).
- `credit_application_decisions` → `CreditApplicationDecisionController` (solo lectura).
- `credit_application_status_history` → `CreditApplicationStatusHistoryController` (solo lectura).
- `credit_application_events` → `CreditApplicationEventController` (solo lectura).
- `credit_application_consents` → `CreditApplicationConsentController` (CRUD parcial sin borrado).
- `credit_application_guarantors` → `CreditApplicationGuarantorController` (CRUD parcial sin borrado).
- `credit_application_conditions` → `CreditApplicationConditionController` (CRUD parcial sin borrado).
- `credit_workflows` → `CreditWorkflowController` (CRUD parcial sin borrado).
- `credit_workflow_versions` → `CreditWorkflowVersionController` (CRUD parcial sin borrado).
- `credit_workflow_steps` → `CreditWorkflowStepController` (CRUD parcial sin borrado).
- `credit_workflow_transitions` → `CreditWorkflowTransitionController` (CRUD parcial sin borrado).
- `credit_workflow_step_roles` → `CreditWorkflowStepRoleController` (CRUD parcial sin borrado).
- `credit_workflow_step_rules` → `CreditWorkflowStepRuleController` (CRUD parcial sin borrado).
- `credit_workflow_instances` → `CreditWorkflowInstanceController` (solo lectura).
- `credit_workflow_tasks` → `CreditWorkflowTaskController` (solo lectura).
- `credit_workflow_task_history` → `CreditWorkflowTaskHistoryController` (solo lectura).
- `credit_workflow_sla` → `CreditWorkflowSlaController` (CRUD parcial sin borrado).
- `credit_line_policies` → `CreditLinePolicyController` (CRUD parcial sin borrado).
- `credit_lines` → `CreditLineController` (solo lectura).
- `credit_line_limit_history` → `CreditLineLimitHistoryController` (solo lectura).
- `credit_line_movements` → `CreditLineMovementController` (solo lectura).
- `credit_drawdowns` → `CreditDrawdownController` (solo lectura).
- `credit_contracts` → `CreditContractController` (solo lectura).
- `credit_loans` → `CreditLoanController` (solo lectura).
- `credit_loan_terms` → `CreditLoanTermController` (solo lectura).
- `credit_amortization_schedules` → `CreditAmortizationScheduleController` (solo lectura).
- `credit_amortization_installments` → `CreditAmortizationInstallmentController` (solo lectura).
- `credit_interest_accruals` → `CreditInterestAccrualController` (solo lectura).
- `credit_penalty_accruals` → `CreditPenaltyAccrualController` (solo lectura).
- `credit_loan_balances` → `CreditLoanBalanceController` (solo lectura).
- `credit_delinquency_snapshots` → `CreditDelinquencySnapshotController` (solo lectura).
- `credit_loan_rate_revisions` → `CreditLoanRateRevisionController` (solo lectura).
- `credit_business_calendars` → `CreditBusinessCalendarController` (CRUD parcial sin borrado).
- `credit_business_holidays` → `CreditBusinessHolidayController` (CRUD parcial sin borrado).
- `credit_product_calendars` → `CreditProductCalendarController` (CRUD parcial sin borrado).
- `credit_payment_channels` → `CreditPaymentChannelController` (CRUD parcial sin borrado).
- `credit_payments` → `CreditPaymentController` (solo lectura).
- `credit_payment_allocations` → `CreditPaymentAllocationController` (solo lectura).
- `credit_loan_ledger_entries` → `CreditLoanLedgerEntryController` (solo lectura).
- `credit_loan_events` → `CreditLoanEventController` (solo lectura).
- `credit_payoff_quotes` → `CreditPayoffQuoteController` (solo lectura).
- `credit_payoff_quote_items` → `CreditPayoffQuoteItemController` (solo lectura).
- `credit_settlements` → `CreditSettlementController` (solo lectura).
- `credit_loan_restructures` → `CreditLoanRestructureController` (solo lectura).
- `credit_loan_adjustments` → `CreditLoanAdjustmentController` (solo lectura).
- `credit_payment_application_policies` → `CreditPaymentApplicationPolicyController` (CRUD parcial sin borrado).
- `credit_payment_application_priorities` → `CreditPaymentApplicationPriorityController` (CRUD parcial sin borrado).
- `pld_policies` → `PldPolicyController` (CRUD parcial sin borrado).
- `pld_policy_versions` → `PldPolicyVersionController` (CRUD parcial sin borrado).
- `pld_rules` → `PldRuleController` (CRUD parcial sin borrado).
- `pld_product_policies` → `PldProductPolicyController` (CRUD parcial sin borrado).
- `pld_client_profiles` → `PldClientProfileController` (CRUD parcial sin borrado).
- `pld_beneficial_owners` → `PldBeneficialOwnerController` (CRUD parcial sin borrado).
- `pld_screenings` → `PldScreeningController` (solo lectura).
- `pld_monitoring_events` → `PldMonitoringEventController` (solo lectura).
- `pld_alerts` → `PldAlertController` (solo lectura).
- `pld_alert_actions` → `PldAlertActionController` (solo lectura).
- `pld_cases` → `PldCaseController` (solo lectura).
- `pld_case_events` → `PldCaseEventController` (solo lectura).
- `pld_reports` → `PldReportController` (solo lectura).
