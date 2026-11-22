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

## Usuario administrador inicial

El seeder `CreditAdministratorSeeder` es deliberadamente **explícito** y no se ejecuta por `DatabaseSeeder`: evita crear cuentas privilegiadas inadvertidamente. Genera `administrador@nahuicredit.com` sólo si no existe otro superadministrador y el correo está libre. No cambia la contraseña de una cuenta existente.

El valor solicitado `admin23` es demasiado corto y conocido para una cuenta administradora: el backend exige 12 caracteres como mínimo y 72 bytes como máximo. No se incorpora ninguna contraseña fija al repositorio.

En un entorno privado y seguro, generar un secreto TOTP Base32 (32 caracteres), registrar el secreto en una aplicación de autenticación compatible y configurar las variables de entorno:

```dotenv
FIDUCREDIT_ADMIN_PASSWORD=<contraseña-segura-de-12-o-más-caracteres>
FIDUCREDIT_ADMIN_MFA_SECRET=<secreto-TOTP-Base32-generado-privadamente>
```

Los valores entre <> son marcadores; nunca subir el archivo .env. No usar esas variables compartidas entre entornos. Ejecutar:

```bash
php artisan config:clear
php artisan db:seed --class=CreditAdministratorSeeder
```

La autenticación de superadministrador ya requiere MFA. La cuenta sólo podrá ingresar si el secreto TOTP queda correctamente registrado en su aplicación autenticadora. Proteger el secreto y rotarlo según el procedimiento de seguridad. 

## Validaciones y pendientes

- Test feature incluido para idempotencia del seeder, cinco acciones por módulo y filtrado por frontend.
- Requiere ejecutar pruebas y migrations con un entorno PHP/SQLite y MySQL 8 antes de fusionar.
- Los menús globales heredados y menús demo con `app_code=NULL` seguirán siendo visibles según permisos, por compatibilidad con el arquetipo.
- Las acciones genéricas `.eliminar` NO habilitan borrados físicos ni transacciones de crédito; los servicios financieros y PLD siguen requiriendo operaciones especializadas y sus políticas.
- Está pendiente completar auditoría de cambios en roles, menús, usuarios y permisos; así como atribución de aplicación verificada y segregación de instituciones.
