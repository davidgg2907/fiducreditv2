# FiduCredit V2 — Etapa de Originación: flujos configurables

## Alcance

Esta etapa agrega **10 tablas** y **10 seeders individuales**, más un seeder coordinador y una clase de fixtures, sin modificar las migraciones heredadas del arquetipo.

En esta entrega, el motor es **configurable a nivel de datos**. No hay todavía interfaz administrativa ni un ejecutor backend que evalúe condiciones y mueva tareas automáticamente.

### Tablas

| Tabla | Responsabilidad |
| --- | --- |
| `credit_workflows` | Flujos por empresa, opcionalmente asignados a un producto |
| `credit_workflow_versions` | Borradores/publicaciones y versiones históricas |
| `credit_workflow_steps` | Etapas con mapeo a estatus/subestatus de solicitud |
| `credit_workflow_transitions` | Acciones autorizables entre etapas, con devolución |
| `credit_workflow_step_roles` | Acceso de roles por etapa (referencia bigint a `roles` heredado) |
| `credit_workflow_step_rules` | Reglas parametrizadas de negocio por etapa y transición |
| `credit_workflow_instances` | Versión exacta de flujo asociada a una solicitud |
| `credit_workflow_tasks` | Bandejas, responsables, prioridades, vencimientos y resolución |
| `credit_workflow_task_history` | Bitácora histórica de tareas |
| `credit_workflow_sla` | Metas y escalamiento de tiempos de atención |

**Identificadores**: las 10 PK son UUID, igual que las otras 30 tablas crediticias. Las FK que apuntan a `users` o `roles` son bigint, porque el arquetipo usa esas PK numéricas y sus migraciones se preservan.

## Flujo de referencia: Crédito personal con nómina

- CAPTURA → MESA_CONTROL (envío)
- MESA_CONTROL → ANALISIS (documentos válidos)
- MESA_CONTROL → CAPTURA (devolución por subsanación)
- ANALISIS → AUTORIZACION (evaluación satisfactoria)
- ANALISIS → CAPTURA (devolución por corrección)
- AUTORIZACION → APROBADA (decisión autorizada)
- AUTORIZACION → RECHAZADA (dictamen motivado)

Los pasos inicial y terminal se identifican mediante `is_initial` e `is_terminal`. Los valores del estado principal son `captured`, `under_review`, `approved` y `rejected`, alineados con las columnas existentes de solicitudes. El flujo de ejemplo crea una instancia y una tarea **pendiente de captura** para la solicitud ficticia `SOL-MTY-2026-000042`; no presenta la solicitud como aprobada ni documenta movimientos no realizados.

## Datos de prueba

Se incluyen funciones idempotentes para crear:
- flujo `ORIG-PERSONAL-NOMINA` publicado, versión 1;
- seis etapas, siete transiciones y cuatro reglas configurables;
- roles operativos de asesor, mesa de control, analista y autorizador;
- una instancia, una tarea inicial, un evento de asignación y cuatro SLA de ejemplo.

Se usan datos ficticios coherentes con `CreditOriginacionFixtures`. Los permisos de los roles generados son **permisos básicos de ejemplo**, no una autorización operativa efectiva: el backend deberá integrarlos con el control de acceso existente.

## Ejecución

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
# Configurar DB_* en .env
php artisan migrate --seed
```

Para añadir solo registros del flujo una vez migradas las tablas y sembrada la Originación:

```bash
php artisan db:seed --class=CreditWorkflowSeeder
```

No ejecutar `migrate:fresh` contra bases con información. Las migraciones son archivos separados, con fecha posterior a las primeras 30 tablas.

## Reglas de integridad por implementar en servicios

1. **Publicación**: validar grafo, caminos a terminales, roles, permisos y reglas antes de publicar. No editar versiones ya publicadas; emitir nueva versión.
2. **Instanciación**: seleccionar la versión publicada para el producto y comprobar que la institución propietaria coincida con la de la solicitud.
3. **Transiciones**: transacción única con bloqueo optimista `lock_version`, verificación del paso actual, rol, reglas, segregación de funciones y trazabilidad; sincronizar `credit_applications.status` y `review_substatus`.
4. **Bandejas**: asignación/reasignación segura y eventos de bitácora inmutables, con filtros por sucursal e institución.
5. **SLA**: calendario laboral real, feriados, zona horaria, suspensiones y notificaciones de escalamiento.
6. **Revisión de documentos**: verificar validaciones contra las versiones de documentos requeridas para ese producto; no inferir aceptación solo por existir un archivo.
7. **Auditoría**: evitar modificaciones y borrados de historial desde la aplicación; aplicar permisos mínimos y controles de retención.
8. **Autorización**: validar montos, políticas, análisis y conflicto de interés del asesor; registrar un dictamen final en `credit_application_decisions`.

**Límite conocido**: las FK garantizan existencia de filas, pero todavía no validan que todos los pasos, transiciones, roles y solicitudes pertenezcan a la misma institución y versión de flujo. Esas invariantes deben implementarse y probarse antes de producción. Tampoco existe todavía un catálogo formal de días inhábiles o un editor gráfico de workflows.

## Notas de evolución

- La instancia tiene relación única con una solicitud; la versión crediticia de la solicitud ya es un registro separado y puede iniciar su propia instancia.
- Para otros productos se crea un nuevo flujo o se reutiliza uno institucional mediante `product_id = null`, con precedencia de asignación definida en la capa de dominio.
- Los módulos Angular de Administración y Originación consumirán APIs del motor y se construirán en una siguiente etapa.
