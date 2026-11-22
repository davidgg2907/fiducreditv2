# Catálogo de menús y acciones — cinco frontends

## Diseño

Las cinco aplicaciones comparten `access_modules`, `module_actions`, `menu_items`, `roles` y `users` en la base de datos principal. La columna incremental `menu_items.app_code` separa las rutas por frontend; `NULL` identifica menús globales heredados (Inicio y Perfil).

| Código de aplicación | Frontend |
| --- | --- |
| originacion | frontend-originacion |
| administracion | frontend-administracion |
| pld-operacion | frontend-pld-operacion |
| pld-configuracion | frontend-pld-configuracion |
| configuracion-sistema | frontend-configuracion-sistema |

El seeder `CreditSystemMenusSeeder` crea secciones jerárquicas y opciones con códigos estables. Por cada módulo genera exactamente cinco acciones: `.ver` (lista/acceso), `.detalle`, `.crear` (captura), `.editar`, `.eliminar` (o baja lógica). Las opciones del menú apuntan a la acción `.ver`; las demás sirven para autorización de botones y endpoints. La ejecución es idempotente y NO concede esos permisos a ningún rol.

Módulos cubiertos: Originación (clientes, domicilios, cuentas, documentos, expedientes, solicitudes, conceptos, consentimientos, obligados, mesa de control, tareas, análisis, buró y dictámenes); Administración (líneas, disposiciones, contratos, créditos, condiciones, amortización, devengos, mora, saldos, recepción/conciliación/aplicación de pagos, liquidaciones, reestructuras y ajustes); PLD Operación (monitoreo, listas, alertas, casos, acciones, evidencias, reportes); PLD Configuración (políticas, versiones, reglas/umbrales, políticas por producto, perfiles y beneficiarios); Sistema (usuarios, roles, permisos, menús, empresas, sucursales, asesores, productos/versiones/comisiones/reglas, campos, documentos, políticas de línea/pago, calendarios, workflows/etapas/reglas/roles/SLA).

Las rutas de estos menús son contratos de navegación **propuestos**, no garantía de que sus pantallas o endpoints de negocio existan todavía.

## Instalar

Desde `backend/`:

```bash
php artisan migrate
php artisan db:seed --class=AccessCatalogSeeder
php artisan db:seed --class=CreditSystemMenusSeeder
php artisan test --filter=CreditSystemMenusSeederTest
```

`DatabaseSeeder` ya incluye `CreditSystemMenusSeeder` inmediatamente después de los catálogos base y roles; `php artisan db:seed` también lo incorpora.

Los cinco interceptores Angular añaden `X-Frontend-App` con su identificador. `/api/me` usa ese valor para devolver opciones de la aplicación más menús globales. **Ese encabezado es una preferencia de presentación, NO una fuente confiable de autorización.** Los endpoints deberán seguir verificando rol, permiso, empresa y sucursal en el servidor; la separación y segregación PLD requiere políticas completas.

## Usuario administrador inicial automático (local)

El comando único `php artisan migrate --seed` ejecuta `CreditAdministratorSeeder` desde `DatabaseSeeder`, sin pedir variables `FIDUCREDIT_ADMIN_PASSWORD` ni `FIDUCREDIT_ADMIN_MFA_SECRET`.

Cuando `APP_ENV=local`, si todavía no existe un superadministrador, crea **administrador@nahuicredit.com**, genera una contraseña aleatoria de 24 caracteres y un secreto TOTP nuevo. Ambos valores se imprimen **una sola vez** en la salida de la consola: deben copiarse de inmediato a un gestor de contraseñas. En la aplicación autenticadora, registrar el secreto TOTP para que el login con MFA funcione.

La contraseña solicitada `admin23` NO se usa: es insuficiente para la política de seguridad de cuentas privilegiadas. El seeder no cambia contraseñas existentes ni crea un segundo superadministrador; si encuentra otro superadministrador, lo conserva. Si el correo ya corresponde a un usuario sin privilegios y todavía no existe un superadministrador, informa del conflicto para su revisión.

En `testing`, `production` y cualquier ambiente distinto de `local`, no se crea una cuenta privilegiada automáticamente. En producción se requiere un proceso formal de aprovisionamiento de identidad y MFA.

```bash
cd backend
php artisan migrate --seed
```

No hace falta ejecutar el seeder de administrador por separado. Si el superadministrador ya existe, la contraseña no se vuelve a imprimir; utiliza recuperación segura y controles de seguridad en lugar de regenerarla mediante seeds.

## Validaciones y pendientes

- Test feature incluido para idempotencia del seeder, cinco acciones por módulo y filtrado por frontend.
- Requiere ejecutar pruebas y migrations con un entorno PHP/SQLite y MySQL 8 antes de fusionar.
- Los menús globales heredados y menús demo con `app_code=NULL` seguirán siendo visibles según permisos, por compatibilidad con el arquetipo.
- Las acciones genéricas `.eliminar` NO habilitan borrados físicos ni transacciones de crédito; los servicios financieros y PLD siguen requiriendo operaciones especializadas y sus políticas.
- Está pendiente completar auditoría de cambios en roles, menús, usuarios y permisos; así como atribución de aplicación verificada y segregación de instituciones.
