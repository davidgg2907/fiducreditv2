# Roles y usuarios por sistema

Configuración del Sistema agrupa el catálogo por prefijo estable `credit_<app_code>_` y módulo. Cada acción conserva su clave original; los permisos generales/heredados se muestran aparte. Al desmarcar un sistema se retiran sus acciones del formulario. Al editar se deducen los sistemas de los permisos guardados; un sistema seleccionado exige al menos una acción. No hay persistencia independiente del sistema.

Usuarios carga las páginas del catálogo de roles y filtra por sistema antes de elegir un único rol (`role_id`). El selector no limita permisos del rol en otros sistemas ni impone autorización de login. No se modifican migraciones, tokens, cardinalidad ni políticas backend. La autorización efectiva por aplicación y el soporte multirrol siguen pendientes.

Validar alta/edición de roles, conservación de permisos heredados, desmarcado de sistemas, filtrado de roles, edición de usuarios, paginación y compilación Angular antes de fusionar.
