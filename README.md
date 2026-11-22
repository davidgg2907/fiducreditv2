# Arquetipo Laravel + Angular

## Instalación local

Requiere PHP 8.4 (8.4.1 como mínimo para las dependencias fijadas), Composer, MySQL o SQLite y Node.js 22.

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
# Ajusta DB_CONNECTION y los datos de la base de datos en .env.
php artisan migrate --seed
php artisan access:bootstrap
php artisan serve --host=localhost
```

En otra terminal, desde `frontend`, ejecuta `npm install` y `npm start`. El proxy de desarrollo dirige `/api` al servidor de Laravel.

El comando `access:bootstrap` crea un único superadministrador. Solicita nombre, correo y contraseña de forma interactiva. Al terminar, copia la clave que aparece en la terminal a tu aplicación de autenticación como clave TOTP (SHA-1, seis dígitos, 30 segundos). En el primer inicio de sesión se solicitará el código después de validar la contraseña. Si pierdes el autenticador, un operador autorizado con acceso a Artisan puede ejecutar `php artisan access:bootstrap --renew-mfa`. Esto cierra la sesión anterior y presenta una nueva clave de inscripción.

## Despliegue

- Sirve el frontend y `/api` por HTTPS, preferentemente en el mismo origen. El directorio público de Laravel es `backend/public`. Usa `APP_ENV=production` y `APP_DEBUG=false`.
- Configura `FRONTEND_URL` con la URL pública de Angular y un servicio real de correo para recuperación. Usa un caché compartido para los límites por cuenta e IP si despliegas varias instancias.
- Si frontend y API usan subdominios del mismo sitio, configura el origen exacto del frontend en `CORS_ALLOWED_ORIGINS` y la URL de API en `frontend/src/assets/app-config.js`. La cookie de renovación es de host, con `SameSite=Lax`; la configuración está orientada a despliegues del mismo sitio.
- Si hay un proxy inverso, registra únicamente las direcciones de confianza en `TRUSTED_PROXIES` para que Laravel reconozca HTTPS. Conserva `APP_KEY` como secreto de despliegue y respáldala de forma segura porque cifra la clave TOTP.
- En una instalación existente, la migración invalida los tokens previos y obliga a volver a entrar. Las migraciones de reclutamiento salen del arquetipo. Las tablas de reclutamiento que ya existan en la base de datos quedan intactas.

## Roles, acciones y menú dinámico

`php artisan migrate --seed` crea el catálogo y carga Inicio, Mi perfil y el rol inicial `Usuario`. En despliegues existentes ejecuta `php artisan migrate --seed --force` como parte de la actualización. Los seeders se pueden volver a ejecutar y conservan los permisos de los roles existentes. El rol inicial se asigna de forma explícita. `access:bootstrap` provisiona el superadministrador con MFA y acceso global al catálogo, incluidos los módulos que se agreguen después.

Cada usuario ordinario puede tener un rol. Un rol contiene claves de acciones como `clientes.ver` y `clientes.editar`. Una entrada del menú puede requerir una acción concreta. Inicio y Mi perfil son entradas base para cualquier sesión autenticada.

### Cuentas ficticias para probar el menú

En `backend/.env`, usa `APP_ENV=local`. Desde `backend` ejecuta:

```bash
php artisan migrate
php artisan db:seed --class=DemoAccessSeeder
```

Si dejas `DEMO_ACCESS_PASSWORD` vacía, Artisan te pedirá una contraseña de al menos 12 caracteres y un máximo de 72 bytes, con la captura oculta. Las tres cuentas usan esa contraseña al crearse. Para automatizar la carga con `--no-interaction`, define la variable en `backend/.env`. Si tienes la configuración en caché, ejecuta `php artisan config:clear` después de editarla.

| Persona ficticia | Correo | Rol demo | Opciones de Gestión de personal |
| --- | --- | --- | --- |
| Mariana Salgado Ríos | `mariana.salgado@arquetipo.test` | Coordinación de Recursos Humanos | Panel de personal y Autoservicio de personal |
| Diego Valdés Herrera | `diego.valdes@arquetipo.test` | Analista de personal | Panel de personal |
| Elena Cortés Medina | `elena.cortes@arquetipo.test` | Colaborador | Autoservicio de personal |

Inicia sesión en Angular con cada cuenta para comparar el submenú y cierra sesión antes de volver a usar la misma cuenta. Los enlaces de ejemplo apuntan a las pantallas existentes `/home` y `/perfil`. La acción `demo_panel_personal.revisar` se incluye en los permisos de Coordinación como ejemplo de una acción sin enlace de menú.

El seeder demo carga el catálogo base y agrega los módulos, sus acciones, el grupo de menú con sus opciones, los roles y las cuentas. Se puede volver a ejecutar y conserva las contraseñas y los roles de las cuentas que ya existen. Las cuentas demo son ordinarias. Para probar el acceso global, crea el superadministrador con `php artisan access:bootstrap` y configura su MFA.

### Crear, editar y asignar roles

Usa un token de acceso del superadministrador con `Authorization: Bearer <token>` y envía `Accept: application/json`. Las escrituras usan JSON.

| Método y ruta | Operación |
| --- | --- |
| `GET /api/access/catalog` | Consulta los módulos y sus acciones disponibles. |
| `GET /api/access/roles` | Consulta los roles y sus permisos. |
| `POST /api/access/roles` | Crea un rol con `{"name":"Consulta","permissions":["clientes.ver"]}`. |
| `PUT /api/access/roles/{role}` | Reemplaza nombre y lista de permisos. Una lista vacía revoca todos los permisos del rol. |
| `PUT /api/access/users/{user}/role` | Asigna un rol con `{"role_id":2}` o retíralo con `{"role_id":null}`. |

La acción del ejemplo debe existir en el catálogo. Las asignaciones usan el identificador del usuario existente. Los cambios se evalúan en Laravel en cada petición que autorice una acción. Angular recibe el menú actualizado al iniciar sesión, renovar el token o volver a cargar el contexto de sesión. `GET /api/me` permite consultar el contexto actual.

### Registrar un módulo nuevo

1. Crea un seeder del módulo e inclúyelo en `DatabaseSeeder`, después de `AccessCatalogSeeder`. Usa una transacción y claves estables para que sea seguro ejecutarlo de nuevo.
2. Registra el módulo en `access_modules` por `code` y sus acciones en `module_actions` por `permission`. Usa el formato `modulo.accion` y vincula cada acción a su `module_id`.
3. Registra las opciones en `menu_items` por `code`. Define una ruta interna de Angular, una etiqueta, un ícono opcional de Material y una posición. Vincula `module_action_id` a la acción que permite ver la entrada. Un valor nulo hace visible la entrada para cualquier usuario autenticado.
4. Agrega la ruta en `frontend/src/app/shared/routes/full-layout.routes.ts` cuando implementes la pantalla. Laravel envía en `data.user` el rol, los permisos y el menú ordenado y filtrado. Angular usa ese menú en la navegación compartida.
5. Al desarrollar el módulo, valida sus operaciones en Laravel con `Gate::authorize('use-permission', 'clientes.editar')` y aplica las Policies correspondientes al recurso. Configura botones, guardias de navegación y otros controles de la pantalla cuando se implemente cada módulo.

Ejemplo para el método `run()` de un seeder, con `use Illuminate\Support\Facades\DB;` en el archivo:

```php
DB::transaction(function (): void {
    DB::table('access_modules')->upsert([
        ['code' => 'clientes', 'name' => 'Clientes'],
    ], ['code'], ['name']);

    $moduleId = DB::table('access_modules')->where('code', 'clientes')->value('id');
    DB::table('module_actions')->upsert([
        ['module_id' => $moduleId, 'permission' => 'clientes.ver', 'name' => 'Ver clientes'],
        ['module_id' => $moduleId, 'permission' => 'clientes.editar', 'name' => 'Editar clientes'],
    ], ['permission'], ['module_id', 'name']);

    $viewId = DB::table('module_actions')->where('permission', 'clientes.ver')->value('id');
    DB::table('menu_items')->upsert([
        [
            'code' => 'clientes',
            'label' => 'Clientes',
            'route' => '/clientes',
            'icon' => 'groups',
            'position' => 30,
            'module_action_id' => $viewId,
        ],
    ], ['code'], ['label', 'route', 'icon', 'position', 'module_action_id']);
});
```

Para agrupar enlaces, crea una entrada raíz con `route = null` y vincula sus enlaces mediante `parent_id`. La navegación admite un nivel de submenú. Un grupo aparece si contiene al menos un enlace permitido. El menú controla qué enlaces se muestran. La autorización de datos y operaciones corresponde a Laravel.

## Pruebas

Ejecuta `composer test` en `backend` con la extensión SQLite habilitada. Las pruebas de integración usan una base de datos en memoria. En `frontend` ejecuta `npm run verify:archetype` y `npm run build`. El workflow hace estas comprobaciones para cada pull request.
