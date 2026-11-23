# FiduCredit V2: CRUD Configuración del Sistema
Se crearon **21 módulos del menú** y **8 recursos complementarios** de configuración. Cada recurso contiene subcarpetas `list`, `form`, `detalle`, y cada componente tiene archivos `.ts`, `.html`, `.scss`. Servicios en `src/app/servicios/configuracion` e interfaces en `src/app/interfaces/configuracion`.
Los formularios reutilizan una ruta parametrizada `/:id/editar` y `/nuevo`; los recursos usan API `/api/access/*` y `/api/v1/credit-*`.
Los botones se autorizan con `credit_configuracion-sistema_{modulo}.ver/detalle/crear/editar/eliminar` o superadministrador. El backend sigue siendo la autoridad real.
**Baja**: los recursos de negocio tienen DELETE deshabilitado (405); no se muestra el botón. Usuarios dispone de suspensión/reactivación. Roles, módulos, acciones y menús permiten borrado condicionado por el servidor.
**Limitaciones**: API de recursos restringida a superadmin; filtros FK y selects traen 25 primeras opciones; publicación de versiones y reglas financieras avanzadas no implementadas; políticas multiempresa requieren refuerzo. No es un motor de crédito productivo. Ejecutar compilación y pruebas antes de despliegue.
