# FiduCredit V2 — Organización de cinco frontends

La plataforma utiliza **cinco aplicaciones Angular independientes**, un backend Laravel compartido (`backend/`) y una sola base de datos.

| Aplicación | Carpeta | Puerto local | Dominio de negocio |
|---|---|---:|---|
| Originación | `frontend-originacion/` | 4200 | Clientes, solicitudes, expedientes, mesa de control, análisis y autorización |
| Administración de Créditos | `frontend-administracion/` | 4201 | Líneas, disposiciones, créditos, amortizaciones, pagos, mora y liquidaciones |
| Operación PLD | `frontend-pld-operacion/` | 4202 | Monitoreo, alertas, investigaciones, casos y reportes |
| Configuración PLD | `frontend-pld-configuracion/` | 4203 | Políticas, versiones, reglas, umbrales y perfiles |
| Configuración del Sistema | `frontend-configuracion-sistema/` | 4204 | Productos, empresas, flujos, usuarios, roles y permisos |

## Cómo se crearon

Las cinco aplicaciones parten de una **copia de los 67 archivos versionados del frontend original**. Cada copia conserva autenticación, diseño visual, menú dinámico, servicios, guardias, estructura de carpetas y configuración de Angular; se actualizó su nombre de paquete, identificador del proyecto Angular, ruta de compilación, página de inicio y puerto local.

La carpeta `frontend/` se conserva **sin cambios** como arquetipo de referencia y para no romper automatizaciones existentes. No forma parte de las cinco aplicaciones definitivas.

## Puesta en marcha

Iniciar Laravel desde `backend/` en el puerto 8000, con migraciones y seeders instalados. En terminales independientes:

```bash
cd frontend-originacion && npm install && npm start
cd frontend-administracion && npm install && npm start
cd frontend-pld-operacion && npm install && npm start
cd frontend-pld-configuracion && npm install && npm start
cd frontend-configuracion-sistema && npm install && npm start
```

Cada comando se ejecuta en su propia terminal desde la raíz del repositorio; no pegarlos uno detrás de otro en una única terminal si están sirviendo continuamente.

Todas las copias conservan un proxy de desarrollo `proxy.conf.json` apuntando a `http://localhost:8000` para `/api` y `/storage`. El archivo `src/assets/app-config.js` permite modificar el origen de API en cada despliegue. **El fallback heredado de API ajena fue reemplazado por rutas locales** en las cinco copias.

## Seguridad y desacoplamiento

- **No duplicar backend ni base de datos**. Los cinco proyectos acceden a endpoints del backend compartido.
- Los roles, permisos, perfiles y segregación por institución se verifican en **Laravel por endpoint**, no exclusivamente por ocultar opciones del menú en Angular.
- La publicación de políticas PLD requiere autorización de cumplimiento; un administrador general no adquiere acceso automático a evidencias PLD.
- Cada aplicación tendrá su propio conjunto de rutas, módulos, tests y despliegue, aunque el menú y el login del arquetipo se conservan por ahora.
- La biblioteca de componentes compartidos, el SSO y la restricción de menús por dominio podrán abordarse más adelante.
- En producción, HTTPS, políticas de CORS/CSRF, sesiones/tokens y orígenes por dominio requieren configuración explícita.

## Importante: estado de esta etapa

**Se copiaron las bases Angular y se diferenció su identidad. Todavía no se implementaron los módulos operativos específicos ni se separaron los permisos o rutas por dominio**. No debe presentarse esta copia como cinco aplicaciones de negocio terminadas.

### Estructura de datos y APIs

Referirse a [ARQUITECTURA_DATOS_FIDUCREDIT_V2.md](ARQUITECTURA_DATOS_FIDUCREDIT_V2.md) para tablas, relaciones y módulos previstos. Cada nuevo módulo deberá implementarse únicamente en el frontend de su dominio y reutilizar los endpoints de Laravel con contratos Request/Response bien definidos.

### Comprobación automática

El workflow `.github/workflows/frontends-fiducredit.yml` compila y verifica las cinco aplicaciones por separado en GitHub Actions. Validar el estado de ejecución después de cada modificación.
