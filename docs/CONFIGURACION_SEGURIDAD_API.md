# FiduCredit V2 — Configuración del Sistema: seguridad y accesos

## Auditoría de las 15 tablas del arquetipo

| Tabla | Acceso recomendado |
| --- | --- |
| users | Administración controlada: consulta, alta, edición, suspensión/reactivación |
| roles | Administración controlada: lista, detalle, crear, editar, eliminación sólo si no está en uso |
| access_modules | Catálogo administrable, impedir eliminación con acciones |
| module_actions | Catálogo administrable, clave de permiso inmutable; impedir eliminación si está referenciado |
| menu_items | Jerarquía administrable, impedir ciclos y eliminación de padres con hijos |
| password_reset_tokens | Sólo endpoints de recuperación de contraseña |
| sessions | Interna de Laravel, nunca CRUD público |
| cache | Interna de Laravel |
| cache_locks | Interna de Laravel |
| jobs | Cola técnica, no exponer CRUD |
| job_batches | Seguimiento de procesamiento técnico |
| failed_jobs | Diagnóstico técnico, no CRUD público |
| oauth_access_tokens | Autenticación y revocación |
| oauth_refresh_tokens | Autenticación y revocación |
| auth_sessions | Login, refresh, cierre y revocación |

## Endpoints de Configuración del Sistema

Todos requieren token válido y autorización `can:manage-access` (superadministrador).

| Verbo | Ruta | Función |
| --- | --- | --- |
| GET | /api/access/catalog | Módulos con acciones autorizables existentes |
| GET, POST | /api/access/roles | Listar / crear roles |
| GET, PUT, DELETE | /api/access/roles/{role} | Detalle / editar / eliminar rol sin dependencias |
| GET, POST | /api/access/users | Listar paginado / crear |
| GET, PUT, PATCH | /api/access/users/{user} | Consultar / editar datos y rol |
| PATCH | /api/access/users/{user}/status | Suspender o reactivar usuario |
| PUT | /api/access/users/{user}/role | Asignación especializada existente |
| GET, POST | /api/access/modules | Listar / crear módulo |
| PUT, DELETE | /api/access/modules/{module} | Editar / eliminar módulo sin acciones |
| GET, POST | /api/access/actions | Listar / crear acción |
| PUT, DELETE | /api/access/actions/{action} | Editar nombre/módulo / eliminar si no está referenciada |
| GET, POST | /api/access/menus | Listar / crear menú |
| PUT, DELETE | /api/access/menus/{menu} | Editar jerarquía / eliminar menú sin hijos |
| GET | /api/me | Sesión con permisos y menú filtrado recursivamente |

### Ejemplos de capturas

Crear usuario:

```json
{"name":"Analista de crédito","email":"analista@example.test","password":"ContrasenaTemporalSegura2026","password_confirmation":"ContrasenaTemporalSegura2026","role_id":2}
```

Suspender usuario: `PATCH /api/access/users/10/status` con `{"is_active":false}`.

Crear rol: `POST /api/access/roles` con `{"name":"Capturista","permissions":["solicitudes.ver","solicitudes.crear"]}`; las claves deben existir en `module_actions`.

Crear acción: `POST /api/access/actions` con `{"module_id":1,"permission":"solicitudes.ver","name":"Ver solicitudes"}`.

Crear menú: `POST /api/access/menus` con `{"code":"solicitudes","label":"Solicitudes","parent_id":null,"module_action_id":1,"route":"/solicitudes","icon":"file-text","position":10}`.

La creación de usuarios nunca acepta `is_superadmin`, ni `is_active` arbitrario. El superadministrador inicial no puede editarse ni suspenderse desde este panel. Los usuarios suspendidos no pueden iniciar sesión, renovar token ni consumir un access token anterior. Los cambios de rol revocan la sesión correspondiente.

No hay borrado físico de usuarios. Las claves de permisos no se renombran en caliente porque `roles.permissions` contiene los identificadores exactos. El frontend debe cargar los catálogos y construir las matrices de roles por módulo/acción.

## Limitaciones y siguientes etapas

- Los endpoints nuevos se incorporaron a una rama de revisión; todavía se deben ejecutar migraciones y pruebas de integración completas en MySQL 8 y SQLite.
- `is_active` se añade a `users` mediante migración incremental, sin reescribir migraciones originales.
- El control administrativo está reservado por ahora al superadministrador; una futura delegación requiere políticas por institución/sucursal, MFA, límites y segregación de funciones.
- `menu_items` todavía no identifica explícitamente a cuál de los cinco frontends pertenece una opción. Antes de activar menús específicos por aplicación conviene añadir un código de aplicación o alcance y filtrar `/api/me` según el cliente autorizado.
- Las modificaciones de configuración de seguridad deben generar bitácora independiente e inmutable antes de producción.
- No se construyeron aún pantallas Angular; este contrato habilita el frontend `frontend-configuracion-sistema`.
