# FiduCredit V2 — Inventario de endpoints y guía para próximas sesiones

**Estado:** inventario comprobado en `main` el 22 de noviembre de 2026.  
**Ámbito:** cinco aplicaciones Angular, un backend Laravel y una base de datos global.  
**Fuentes verificadas:** `backend/routes/api.php`, `docs/ARQUITECTURA_DATOS_FIDUCREDIT_V2.md` y `docs/API_RECURSOS_FIDUCREDIT_V2.md`.

> Este documento distingue **rutas registradas** de **operaciones de negocio terminadas**. Un endpoint registrado NO implica que se hayan implementado las reglas financieras, la seguridad por institución ni todos los flujos operativos.

## 1. Estado general

- **98 tablas** en el diccionario de datos: 83 de negocio y 15 de soporte/identidad/infraestructura.
- **83 rutas de recursos REST** `Route::apiResource` para las 83 tablas crediticias y PLD (sin faltantes en el inventario de dominio).
- **83 controladores explícitos, modelos, servicios y repositorios**, dos FormRequests y un Resource por entidad de dominio.
- **Un endpoint adicional** de captura masiva financiera `POST /api/v1/credit-applications/{id}/financial-items/batch`.
- **Endpoints heredados** de login, recuperación de contraseña, perfil, catálogo de acceso y gestión parcial de roles.
- **No se implementaron** todavía los casos de uso financieros (pago aplicado, generación definitiva de amortización, desembolso, liquidación), publicación/control de workflows ni los procedimientos regulatorios PLD.
- Los archivos están en sus carpetas raíz correspondientes; **no** existe dependencia con `DomainResourceController`, `DomainCrudService` o `DomainWriteRequest`.

## 2. Convenciones REST de los 83 recursos

Para cada ruta base `/api/v1/{recurso}` existe la declaración de `Route::apiResource`:

| HTTP | Ruta | Operación del controlador | Observación |
|---|---|---|---|
| GET | `/api/v1/{recurso}` | `index` | Listado paginado; filtros de igualdad, orden e `include` de relaciones |
| GET | `/api/v1/{recurso}/{id}` | `show` | Detalle por UUID; `include` opcional |
| POST | `/api/v1/{recurso}` | `store` | Puede devolver **405** en entidades protegidas |
| PUT/PATCH | `/api/v1/{recurso}/{id}` | `update` | Puede devolver **405** en entidades protegidas |
| DELETE | `/api/v1/{recurso}/{id}` | `destroy` | **405** en el diseño actual; no se realiza eliminación física |

Todas las rutas usan parámetros `{id}` cortos para evitar el límite de Symfony. El prefijo Laravel `/api` se aplica a `routes/api.php`.

**Consultas soportadas:** `?per_page=25&sort=created_at&direction=desc&filter[client_id]=UUID&include=client`. Los nombres de relaciones deben existir realmente en Eloquent. `per_page` permite 1–100 y `include` hasta seis relaciones. Las consultas deben revisarse por rendimiento y autorización antes de abrirse a usuarios operativos.

**Seguridad provisional:** autenticación con token, acceso de dominio limitado principalmente a `is_superadmin`. PLD requiere además permisos `pld-data.view` y `pld-data.write`. **Pendiente:** usuarios normales, institución, sucursal y permisos por acción. Los `Resources` genéricos actuales todavía requieren control de exposición de PII.

## 3. Inventario completo de recursos de negocio

Las rutas de cada fila tienen el patrón HTTP documentado en la sección anterior.

### Originación: empresas, productos y expediente

| Tabla | Ruta base registrada | Controller | Escritura / alcance |
|---|---|---|---|
| `credit_companies` | `/api/v1/credit-companies` | `CreditCompanyController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_branches` | `/api/v1/credit-branches` | `CreditBranchController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_advisors` | `/api/v1/credit-advisors` | `CreditAdvisorController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_products` | `/api/v1/credit-products` | `CreditProductController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_product_versions` | `/api/v1/credit-product-versions` | `CreditProductVersionController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_product_fees` | `/api/v1/credit-product-fees` | `CreditProductFeeController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_product_rules` | `/api/v1/credit-product-rules` | `CreditProductRuleController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_custom_fields` | `/api/v1/credit-custom-fields` | `CreditCustomFieldController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_product_fields` | `/api/v1/credit-product-fields` | `CreditProductFieldController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_clients` | `/api/v1/credit-clients` | `CreditClientController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_client_addresses` | `/api/v1/credit-client-addresses` | `CreditClientAddressController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_client_address_versions` | `/api/v1/credit-client-address-versions` | `CreditClientAddressVersionController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_client_bank_accounts` | `/api/v1/credit-client-bank-accounts` | `CreditClientBankAccountController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_document_types` | `/api/v1/credit-document-types` | `CreditDocumentTypeController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_document_validation_rules` | `/api/v1/credit-document-validation-rules` | `CreditDocumentValidationRuleController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_product_documents` | `/api/v1/credit-product-documents` | `CreditProductDocumentController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_applications` | `/api/v1/credit-applications` | `CreditApplicationController` | POST de borrador compuesto: financiera, archivos y consentimientos |
| `credit_application_fields` | `/api/v1/credit-application-fields` | `CreditApplicationFieldController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_application_documents` | `/api/v1/credit-application-documents` | `CreditApplicationDocumentController` | POST/PUT bloqueados: carga privada integrada con solicitud (carga posterior pendiente) |
| `credit_document_checks` | `/api/v1/credit-document-checks` | `CreditDocumentCheckController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_application_financial_items` | `/api/v1/credit-application-financial-items` | `CreditApplicationFinancialItemController` | POST individual y endpoint POST batch adicional |
| `credit_application_financial_summaries` | `/api/v1/credit-application-financial-summaries` | `CreditApplicationFinancialSummaryController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_bureau_inquiries` | `/api/v1/credit-bureau-inquiries` | `CreditBureauInquiryController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_application_analyses` | `/api/v1/credit-application-analyses` | `CreditApplicationAnalyseController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_application_decisions` | `/api/v1/credit-application-decisions` | `CreditApplicationDecisionController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_application_status_history` | `/api/v1/credit-application-status-history` | `CreditApplicationStatusHistoryController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_application_events` | `/api/v1/credit-application-events` | `CreditApplicationEventController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_application_consents` | `/api/v1/credit-application-consents` | `CreditApplicationConsentController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_application_guarantors` | `/api/v1/credit-application-guarantors` | `CreditApplicationGuarantorController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_application_conditions` | `/api/v1/credit-application-conditions` | `CreditApplicationConditionController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |

### Motor de flujo y Mesa de Control

| Tabla | Ruta base registrada | Controller | Escritura / alcance |
|---|---|---|---|
| `credit_workflows` | `/api/v1/credit-workflows` | `CreditWorkflowController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_workflow_versions` | `/api/v1/credit-workflow-versions` | `CreditWorkflowVersionController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_workflow_steps` | `/api/v1/credit-workflow-steps` | `CreditWorkflowStepController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_workflow_transitions` | `/api/v1/credit-workflow-transitions` | `CreditWorkflowTransitionController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_workflow_step_roles` | `/api/v1/credit-workflow-step-roles` | `CreditWorkflowStepRoleController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_workflow_step_rules` | `/api/v1/credit-workflow-step-rules` | `CreditWorkflowStepRuleController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_workflow_instances` | `/api/v1/credit-workflow-instances` | `CreditWorkflowInstanceController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_workflow_tasks` | `/api/v1/credit-workflow-tasks` | `CreditWorkflowTaskController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_workflow_task_history` | `/api/v1/credit-workflow-task-history` | `CreditWorkflowTaskHistoryController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_workflow_sla` | `/api/v1/credit-workflow-sla` | `CreditWorkflowSlaController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |

### Administración: líneas y crédito activo

| Tabla | Ruta base registrada | Controller | Escritura / alcance |
|---|---|---|---|
| `credit_line_policies` | `/api/v1/credit-line-policies` | `CreditLinePolicyController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_lines` | `/api/v1/credit-lines` | `CreditLineController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_line_limit_history` | `/api/v1/credit-line-limit-history` | `CreditLineLimitHistoryController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_line_movements` | `/api/v1/credit-line-movements` | `CreditLineMovementController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_drawdowns` | `/api/v1/credit-drawdowns` | `CreditDrawdownController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_contracts` | `/api/v1/credit-contracts` | `CreditContractController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loans` | `/api/v1/credit-loans` | `CreditLoanController` | **405** en POST/PUT/PATCH: requiere operación de negocio |

### Administración: intereses, amortización y cartera

| Tabla | Ruta base registrada | Controller | Escritura / alcance |
|---|---|---|---|
| `credit_loan_terms` | `/api/v1/credit-loan-terms` | `CreditLoanTermController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_amortization_schedules` | `/api/v1/credit-amortization-schedules` | `CreditAmortizationScheduleController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_amortization_installments` | `/api/v1/credit-amortization-installments` | `CreditAmortizationInstallmentController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_interest_accruals` | `/api/v1/credit-interest-accruals` | `CreditInterestAccrualController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_penalty_accruals` | `/api/v1/credit-penalty-accruals` | `CreditPenaltyAccrualController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loan_balances` | `/api/v1/credit-loan-balances` | `CreditLoanBalanceController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_delinquency_snapshots` | `/api/v1/credit-delinquency-snapshots` | `CreditDelinquencySnapshotController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loan_rate_revisions` | `/api/v1/credit-loan-rate-revisions` | `CreditLoanRateRevisionController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_business_calendars` | `/api/v1/credit-business-calendars` | `CreditBusinessCalendarController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_business_holidays` | `/api/v1/credit-business-holidays` | `CreditBusinessHolidayController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_product_calendars` | `/api/v1/credit-product-calendars` | `CreditProductCalendarController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |

### Administración: pagos, movimientos y liquidación

| Tabla | Ruta base registrada | Controller | Escritura / alcance |
|---|---|---|---|
| `credit_payment_channels` | `/api/v1/credit-payment-channels` | `CreditPaymentChannelController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_payments` | `/api/v1/credit-payments` | `CreditPaymentController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_payment_allocations` | `/api/v1/credit-payment-allocations` | `CreditPaymentAllocationController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loan_ledger_entries` | `/api/v1/credit-loan-ledger-entries` | `CreditLoanLedgerEntryController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loan_events` | `/api/v1/credit-loan-events` | `CreditLoanEventController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_payoff_quotes` | `/api/v1/credit-payoff-quotes` | `CreditPayoffQuoteController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_payoff_quote_items` | `/api/v1/credit-payoff-quote-items` | `CreditPayoffQuoteItemController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_settlements` | `/api/v1/credit-settlements` | `CreditSettlementController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loan_restructures` | `/api/v1/credit-loan-restructures` | `CreditLoanRestructureController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_loan_adjustments` | `/api/v1/credit-loan-adjustments` | `CreditLoanAdjustmentController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `credit_payment_application_policies` | `/api/v1/credit-payment-application-policies` | `CreditPaymentApplicationPolicyController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `credit_payment_application_priorities` | `/api/v1/credit-payment-application-priorities` | `CreditPaymentApplicationPriorityController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |

### Prevención de Lavado de Dinero y Financiamiento al Terrorismo (PLD/FT)

| Tabla | Ruta base registrada | Controller | Escritura / alcance |
|---|---|---|---|
| `pld_policies` | `/api/v1/pld-policies` | `PldPolicyController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `pld_policy_versions` | `/api/v1/pld-policy-versions` | `PldPolicyVersionController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `pld_rules` | `/api/v1/pld-rules` | `PldRuleController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `pld_product_policies` | `/api/v1/pld-product-policies` | `PldProductPolicyController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `pld_client_profiles` | `/api/v1/pld-client-profiles` | `PldClientProfileController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `pld_beneficial_owners` | `/api/v1/pld-beneficial-owners` | `PldBeneficialOwnerController` | POST/PUT/PATCH de captura/configuración, sujetos a restricciones |
| `pld_screenings` | `/api/v1/pld-screenings` | `PldScreeningController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `pld_monitoring_events` | `/api/v1/pld-monitoring-events` | `PldMonitoringEventController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `pld_alerts` | `/api/v1/pld-alerts` | `PldAlertController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `pld_alert_actions` | `/api/v1/pld-alert-actions` | `PldAlertActionController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `pld_cases` | `/api/v1/pld-cases` | `PldCaseController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `pld_case_events` | `/api/v1/pld-case-events` | `PldCaseEventController` | **405** en POST/PUT/PATCH: requiere operación de negocio |
| `pld_reports` | `/api/v1/pld-reports` | `PldReportController` | **405** en POST/PUT/PATCH: requiere operación de negocio |

## 4. Captura compuesta y por lotes existentes

### 4.1 Crear solicitud completa (etapa de captura)

`POST /api/v1/credit-applications`

Permite registrar en una operación lógica un borrador de solicitud y sus colecciones relacionadas. Cuando hay documentos utiliza `multipart/form-data`: `financial_items[n][...]`, `documents[n][document_type_id]`, `documents[n][file]` y `consents[n][...]`. Los documentos se guardan en almacenamiento privado con limpieza compensatoria de archivos si se revierte la transacción SQL. El usuario autenticado se utiliza para los campos de autoría y captura.

**No** ejecuta envío a workflow, dictamen o autorización. El versionado posterior de documentos es un caso de uso pendiente.

### 4.2 Insertar ingresos y egresos de forma masiva

`POST /api/v1/credit-applications/{id}/financial-items/batch`

```json
{
  "items": [
    {"entry_type": "income", "concept": "Sueldo", "amount": "25000.00", "frequency": "monthly"},
    {"entry_type": "expense", "concept": "Renta", "amount": "6000.00", "frequency": "monthly"}
  ]
}
```

Admite hasta 200 registros y verifica que la solicitud permanezca en captura antes de realizar una inserción múltiple en transacción.

## 5. Las 15 tablas del arquetipo: exposición y justificación

| Tabla | API existente o función | ¿CRUD directo? | Pendiente / motivo |
|---|---|---|---|
| `users` | `/api/me`, perfil, contraseña y `PUT /api/access/users/{user}/role` | **Incompleto** | CRUD administrativo de usuarios, activación/baja lógica y segregación por institución y sucursal |
| `roles` | `GET/POST /api/access/roles`, `PUT /api/access/roles/{role}` | **Parcial** | Detalle individual, auditoría, restricciones de edición/eliminación |
| `access_modules` | `GET /api/access/catalog` | **No CRUD de administración** | Planear mantenimiento autorizado de catálogo de módulos |
| `module_actions` | `GET /api/access/catalog` | **No CRUD de administración** | Planear mantenimiento y registro controlado de permisos por acción |
| `menu_items` | Utilizado por el menú de sesión (`GET /api/me`) | **No CRUD administrativo** | Editor jerárquico, orden, visibilidad por perfil y aplicación |
| `password_reset_tokens` | `POST /api/password/forgot`, `POST /api/password/reset` | No | Token sensible: creación y uso solo a través de recuperación de contraseña |
| `sessions` | Manejo interno de sesiones Laravel | No | Nunca exponer payload de sesiones ni CRUD directo |
| `cache` | Caché interna de Laravel | No | Sin acceso público directo |
| `cache_locks` | Bloqueos internos de caché | No | Protege coordinación técnica; sin CRUD HTTP |
| `jobs` | Cola interna | No | Eventual consola técnica protegida; sin manipulación arbitraria de payload |
| `job_batches` | Seguimiento interno de trabajos | No | Eventual monitor de procesamiento, no CRUD público |
| `failed_jobs` | Registro de fallos de cola | No | Eventual revisión/reintento solo para perfiles técnicos |
| `oauth_access_tokens` | Login, refresh y logout del sistema | No | Emisión/revocación mediante autenticación, nunca escritura directa |
| `oauth_refresh_tokens` | `POST /api/login/refresh` | No | Renovación y revocación controladas |
| `auth_sessions` | Sesión unificada y expiración de autenticación | No | Gestión mediante `/api/login`, `/api/login/refresh`, `/api/logout`; considerar cierre remoto de sesiones con política de seguridad |

**Rutas existentes verificadas en `routes/api.php`**

```text
GET   /api/login/branding
POST  /api/login
POST  /api/login/refresh
POST  /api/logout
POST  /api/password/forgot
POST  /api/password/reset
GET   /api/me
GET   /api/perfil
POST  /api/perfil
POST  /api/perfil/contrasena
GET   /api/access/catalog
GET   /api/access/roles
POST  /api/access/roles
PUT   /api/access/roles/{role}
PUT   /api/access/users/{user}/role
```

## 6. Planeación de endpoints pendientes por frontend

**Importante:** las siguientes son **propuestas**, NO rutas actualmente registradas.

| Frontend | Endpoints/casos de uso por crear | Prioridad |
|---|---|---|
| Configuración del Sistema | Usuarios: alta, consulta, edición, suspensión, baja lógica; roles y permisos; catálogos de módulos, acciones y menús | P0 |
| Configuración del Sistema | Vinculación usuario–empresa–sucursal, políticas de autorización y alcance | P0 |
| Configuración del Sistema | Publicar/versionar productos y workflows; clonar configuración | P1 |
| Originación | Cliente y expediente compuesto; validación cruzada de cliente, cuenta y domicilio | P0 |
| Originación | Documentos: carga posterior, nueva versión, revisión/rechazo, descarga segura | P0 |
| Originación | Solicitud: guardar borrador, enviar, devolver, clonar, dictaminar | P0 |
| Originación | Workflow: reclamar, asignar, avanzar, regresar, terminar tarea; auditoría | P0 |
| Originación | Análisis: lotes, consolidación, simulación financiera y decisión | P1 |
| Administración | Líneas: apertura autorizada, bloqueo de límite y disposición concurrente | P0 |
| Administración | Créditos: creación transaccional postdisposición y publicación de amortización | P0 |
| Administración | Pagos: recepción, conciliación, aplicación fecha valor, reversos, liquidaciones | P0 |
| Administración | Mora, devengos, reestructuras, cotización de liquidación y cierre | P1 |
| Configuración PLD | Política/versiones, reglas/umbrales, publicación controlada, perfiles | P0 |
| Operación PLD | Monitoreo, asignación/resolución de alertas, casos, evidencias, reportes | P0 |

**No** implementar operaciones reales de disposición, liquidación, pagos, interés o reportes regulatorios sin reglas, idempotencia, autorización, concurrencia, auditoría, pruebas y cumplimiento aplicable.

## 7. Lista de verificación por entidad para las próximas sesiones

- [ ] Identificar frontend dueño, roles autorizados y capacidad de consulta/alta/edición/baja lógica.
- [ ] Confirmar columnas/relaciones contra la migración y el modelo (incluidas FK de institución).
- [ ] Definir Request de captura individual, compuesta o masiva; reglas cruzadas y límites.
- [ ] Definir Resource de listado, detalle y campos sensibles por perfil.
- [ ] Implementar Controller explícito y Service específico; transacción sobre varios repositorios cuando proceda.
- [ ] Mantener Repository de persistencia y consultas eficientes; diseñar índices y filtros permitidos.
- [ ] Establecer política de seguridad de backend para permisos módulo/acción, institución y sucursal.
- [ ] Especificar estados, versionado, auditoría, idempotencia y reversos/compensaciones según el caso.
- [ ] Probar éxito, validación 422, acceso 401/403, no encontrado 404, operación no permitida 405, rollback y concurrencia.
- [ ] Integrar componentes Angular (listas, detalle, alta/edición, relaciones, mensajes de error y permisos).
- [ ] Actualizar este inventario y la documentación de contratos Request/Response.

## 8. Estado de implementación y fuentes de verdad

Este documento es una **fotografía de rutas registradas en main**, no certifica que todas las operaciones funcionen con usuarios de producción. Verificar implementación técnica en `backend/routes/api.php`, `backend/app/Http/Controllers`, `backend/app/Services`, `backend/app/Repositories`, `backend/app/Http/Requests`, `backend/app/Http/Resources`, y estructura relacional en `backend/database/migrations`.

Para cada sesión futura, seleccionar un módulo de la sección 6, revisar su implementación actual y actualizar el estado (propuesto → implementado → probado → conectado al frontend). Nunca confundir la presencia de `apiResource` con un caso de uso financiero finalizado.
