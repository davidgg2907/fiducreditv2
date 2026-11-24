# Diagnóstico de restauración de sesión en FiduCredit V2

La cookie de renovación es HttpOnly, SameSite=Lax, Path=/api y está identificada como `nahuicredit_v2_refresh` para evitar que otro arquetipo Laravel alojado en localhost sobrescriba `archetype_refresh`. Con el cambio de nombre, el navegador debe volver a iniciar sesión una sola vez y usar la opción explícita de sustituir una sesión anterior si está bloqueada.

## Prueba de F5
En Chrome DevTools > Network, activar Preserve log. Iniciar sesión en http://localhost:4204 y observar la respuesta POST /api/login: debe traer Set-Cookie nahuicredit_v2_refresh. F5 debe producir POST /api/login/refresh que envíe esa cookie y devuelva 200. No copiar ni compartir el valor de las cookies. Si no se envía, revisar si el navegador está usando otro hostname (127.0.0.1 frente a localhost), si bloquea cookies, y que Angular esté usando /api/ con el proxy configurado. Si devuelve 401 aun enviando la cookie, revisar el servidor y el estado de auth_sessions. El frontend no puede reconstruir una credencial de renovación que el navegador no conserva.

Las pruebas del backend cubren login, POST /api/login/refresh con cookie, autorización GET /api/me y una segunda renovación después de rotar la cookie. La compilación Angular sola no comprueba comportamiento de cookies en un navegador.
