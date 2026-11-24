# Sesiones y captura institucional (2026-11-24)

## Sesiones
- Token de acceso en memoria y refresh token en cookie HttpOnly. Los cinco frontends recuperan sesión al recargar mediante POST /api/login/refresh, sin depender exclusivamente de sessionStorage.
- Renovación anticipada cuando hay actividad reciente (< 10 minutos), pestaña visible y el token vence en 2 minutos.
- Ante HTTP 409 al iniciar sesión, se intenta reanudar con la cookie previa sin saltarse el control de sesión única.
- Tiempos de backend: access token 15 min, refresh token 1440 min (o 43200 con recordar), inactividad 90 min. Los límites de backend mantienen prioridad; no se guardan credenciales en localStorage.
- Verificar que el navegador reciba la cookie con ruta /api y que frontend/backend utilicen origen o proxy correcto. Si se borró la cookie y permanece una sesión activa del servidor, no es posible recuperarla sin mecanismos adicionales de revocación autenticada.

## Captura
- Empresas, Sucursales y Asesores tienen domicilio separado: calle, colonia, ciudad, estado, municipio, código postal (estado y municipio existentes se conservan en Sucursales).
- Asesores incorporan nombre, teléfono, correo, domicilio, acceso al sistema y alta transaccional de usuario con rol.
- Usuarios exigen contraseña y confirmación coincidentes.
- En menú de Configuración del Sistema se ocultan Módulos y acciones, Menús por aplicación y Versiones de productos, sin eliminar permisos ni datos.
- Ejecutar php artisan migrate y verificar formularios con cuentas de prueba; no regenerar tablas destructivamente.
