# FiduCredit V2 — Administración de Crédito y PLD (Etapa de estructura de BD)

## Entrega y alcance

Se agregaron **43 tablas** propias de Administración y PLD, cada una con migración independiente, llave UUID y seeder individual. Se conservaron intactas las migraciones originales del arquetipo y las migraciones existentes de Originación. Se enlaza `CreditAdministrationSeeder` en `DatabaseSeeder`.

**La presente entrega define persistencia y datos ficticios; no desarrolla aún los algoritmos productivos de interés, administración, conciliación, monitorización PLD, reportes regulatorios ni endpoints Angular/Laravel.**

### Relación de negocio

```text
credit_applications (aprobada)
  └─ credit_lines (1 línea / solicitud de autorización de línea)
       ├─ credit_drawdowns (1..n disposiciones bajo reglas de producto)
       │    └─ credit_loans (1 crédito por disposición)
       │         ├─ credit_loan_terms (versiones de condiciones)
       │         ├─ credit_amortization_schedules (versionadas)
       │         │    └─ credit_amortization_installments
       │         ├─ credit_interest_accruals / credit_penalty_accruals
       │         ├─ credit_payments ─ credit_payment_allocations
       │         ├─ credit_loan_ledger_entries (movimientos reversibles por contrapartida)
       │         ├─ credit_loan_balances (vista materializada/reconciliable)
       │         ├─ credit_payoff_quotes ─ credit_payoff_quote_items ─ credit_settlements
       │         └─ credit_loan_events / credit_delinquency_snapshots
       └─ credit_line_movements / credit_line_limit_history

credit_product_versions
  ├─ credit_line_policies / credit_payment_application_policies
  │                              └─ credit_payment_application_priorities
  ├─ credit_product_calendars ─ credit_business_calendars ─ credit_business_holidays
  └─ pld_product_policies ─ pld_policy_versions ─ pld_rules
                                                    └─ pld_alerts / pld_cases
```

### Distribución (43 tablas)

- **Línea y disposiciones (7)**: `credit_line_policies`, `credit_lines`, `credit_line_limit_history`, `credit_line_movements`, `credit_drawdowns`, `credit_contracts`, `credit_loans`.
- **Condiciones, amortización y devengos (5)**: `credit_loan_terms`, `credit_amortization_schedules`, `credit_amortization_installments`, `credit_interest_accruals`, `credit_penalty_accruals`.
- **Pagos, saldos, liquidación y operaciones (12)**: `credit_payment_channels`, `credit_payments`, `credit_payment_allocations`, `credit_loan_ledger_entries`, `credit_loan_balances`, `credit_loan_events`, `credit_payoff_quotes`, `credit_payoff_quote_items`, `credit_settlements`, `credit_loan_restructures`, `credit_loan_adjustments`, `credit_delinquency_snapshots`.
- **Prevención de lavado de dinero (13)**: `pld_policies`, `pld_policy_versions`, `pld_rules`, `pld_product_policies`, `pld_client_profiles`, `pld_beneficial_owners`, `pld_screenings`, `pld_monitoring_events`, `pld_alerts`, `pld_alert_actions`, `pld_cases`, `pld_case_events`, `pld_reports`.
- **Reglas operativas y calendarios (6)**: `credit_payment_application_policies`, `credit_payment_application_priorities`, `credit_business_calendars`, `credit_business_holidays`, `credit_loan_rate_revisions`, `credit_product_calendars`.

### Precisión financiera: reglas pendientes del motor

Todos los importes monetarios se guardan en DECIMAL(18,2); tasas en DECIMAL(12,8) o precisión específica; **no utilizar floats para cálculos definitivos**. Utilizar cálculo decimal de precisión controlada (por ejemplo BCMath) y consolidar centavos con método de redondeo configurable.

- **Interés ordinario**: calcular capital base × tasa anual × fracción de días `ACT/365`, `ACT/360` o `30E/360` según contrato. Los períodos/fecha valor y cualquier cambio de tasa deben considerarse de manera determinista, sin doble devengo.
- **Interés moratorio**: distinguir base moratoria elegible, días de atraso, periodo y tasa; no capitalizar automáticamente, no calcular sobre cargos prohibidos y aplicar el límite permitido contractualmente y por el régimen aplicable.
- **Tabla de amortización**: almacenar capital inicial, interés, capital amortizado, impuestos, comisiones, saldo final por cuota. Una reestructura crea nueva versión; no destruir cuotas pasadas.
- **Pago**: recepción → verificación/PLD → aplicación por orden configurable → entradas de libro mayor → actualización atómica de saldos. `received` no equivale a `posted`; una recepción pendiente no amortiza capital.
- **Línea no revolvente**: la disponibilidad disminuye al disponer y no se restituye con pagos; línea revolvente: restituir capital únicamente bajo política de producto. Proteger operaciones concurrentes con control optimista `lock_version`.
- **Liquidación**: generar cotización *a fecha valor* con principal pendiente + devengos ordinarios + moratorios + impuestos + comisiones aplicables − créditos/saldos a favor; verificar vigencia, conciliación y monto recibido antes de marcar como liquidado. Las diferencias residuales centavo a centavo requieren una política documentada.
- **Calendario**: periodos, inhábiles, feriados y ajustes de fecha de vencimiento deben ser configurables y reflejar calendario de la entidad.

### PLD/FT

La política y su versión existen por **institución**, y pueden vincularse a **versiones de productos**. El monitoreo guarda eventos ligados opcionalmente a disposiciones, pagos y liquidaciones; una regla puede producir alerta, que se investiga en un caso y puede derivar en un reporte.

**No se incorporan umbrales regulatorios obligatorios ni una clasificación jurídica universal**: antes de usar en producción se debe identificar si la institución es SOFOM ENR, entidad regulada, sujeto de actividades vulnerables u otro régimen; adoptar las disposiciones vigentes, las reglas de reporte aplicables y el manual PLD/FT de la institución. La parametrización interna no exime de obligaciones legales.

No automatizar envío de reportes a autoridad, congelamiento de recursos o acusaciones por coincidencias de listas. Registrar versión de lista, proveedor, evidencia, fecha de consulta y resolución del oficial de cumplimiento. Aplicar mínimo privilegio, protección de datos personales y trazabilidad no modificable.

### Fixture demostrativo

Se preserva **capturada** la solicitud original `SOL-MTY-2026-000042`. Se genera una *nueva* solicitud ficticia aprobada `SOL-MTY-2026-000051`, con línea no revolvente de **$25,000**, disposición de prueba de **$12,000** y crédito activo por **$12,000** a 6 meses (tasa anual ficticia del **28%**). La tabla ilustrativa usa mensualidad francesa nominal, 28%/12 y ajuste del último capital: principal total $12,000, interés programado **$998.83**, total **$12,998.83** (sin impuestos/comisiones), sujeto a recálculo con convención contractual exacta de días.

Una recepción de pago ficticia por $1,000 queda `received`, **sin aplicación**. Existe una cotización de liquidación ilustrativa de **$12,009.33** con fecha valor 2026-11-21, calculada para un día devengado bajo 30/360, **sin pago de liquidación**; un evento separado de *intento de pago atípico* genera una **alerta PLD de simulación**, no una acusación ni un reporte presentado.

La cuenta destino usada en fixtures anteriores **no contiene CLABE validada** y el contrato sintético no tiene archivo firmado; nunca interpretar registros de prueba como una transferencia o contratación efectuada. Para construir escenarios reales de integración, primero completar KYC, contratos, verificación bancaria y autorizaciones.

Algunas tablas sensibles a estados excepcionales, como moratorios, aplicaciones de pagos, reestructuras, liquidaciones consumadas y reportes oficiales, poseen **seeder independiente que no inserta registros inventados**; se poblarán con pruebas de flujo después de implementar el motor transaccional.

### Instalar / verificar

```bash
git pull origin main
cd backend
composer install
php artisan migrate --seed
php artisan migrate:status
```

Para cargar Administración únicamente, las tablas y los seeders de Originación y de flujos deben existir:

```bash
php artisan db:seed --class=CreditAdministrationSeeder
```

**Precaución**: evitar `migrate:fresh` y `rollback` contra bases con información productiva. El workflow `.github/workflows/credit-schema.yml` tiene validación de sintaxis y migración/seed en una base SQLite descartable; se requiere validar adicionalmente MySQL 8, integridad de claves externas, datos seed y rollback. No se ha certificado aún una corrida exitosa desde este entorno.

### Próximos componentes de backend

1. Aplicación de solicitud aprobada → línea → disposiciones → crédito mediante transacciones e idempotencia.
2. Motor financiero decimal: devengo ordinario, moratorio, ajuste de fechas valor, amortizaciones por producto, simulaciones y reestructuras.
3. Motor de aplicación de pagos, conciliación, reversos y reconstrucción de saldos por libro mayor.
4. Servicio de cotización de saldo para liquidar con prueba de fecha valor y cancelación de línea/disponibilidad.
5. Motor PLD para políticas versionadas, perfiles de riesgo, alertas y casos, con controles por régimen jurídico.
6. Endpoints auditables y controles de permisos en Angular Administración.
