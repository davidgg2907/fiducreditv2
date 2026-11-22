# FiduCredit V2 — Originación etapa 1

- Arquetipo conservado sin alterar migraciones originales.
- 30 tablas nuevas, una migración por tabla, UUID en PK de tablas crediticias.
- La tabla existente `users` utiliza bigint; las FK `created_by`, `user_id`, etc. se adaptaron a bigint.
- Las cuentas bancarias de prueba carecen de CLABE completa y los documentos de prueba apuntan a rutas ilustrativas, sin archivo real.
- Los RFC/CURP de clientes de prueba se dejaron vacíos para no simular identificadores de personas reales.

## Comandos

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
# configurar conexión DB en .env
php artisan migrate
php artisan db:seed --class=CreditOriginacionSeeder
```

**Importante:** primero ejecutar las migraciones originales y después el seeder. Las reglas de aprobación no se aplican automáticamente por estas tablas: falta implementarlas en servicios de dominio y agregar pruebas automatizadas. La bitácora debe ser de inserción única desde la aplicación. Los documentos y datos sensibles requieren almacenamiento privado, cifrado, control de acceso y políticas de retención.
