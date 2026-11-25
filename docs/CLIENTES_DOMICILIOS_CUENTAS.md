# Clientes: captura integrada

Listado: iconos Domicilios y Cuentas bancarias abren un diálogo por cliente. Detalle: secciones con registros y acceso al diálogo. Alta/edición: captura opcional, edición de la dirección/cuenta más reciente por fecha de registro, diálogo para consultar y editar otras; aplicar al formulario no persiste hasta Guardar cliente.

API: GET /api/v1/credit-clients/{id}?client_relations=1 devuelve relaciones y versiones. POST/PUT del cliente aceptan addresses y bank_accounts, cada elemento con id opcional. La transacción guarda cliente y relaciones, comprueba propiedad de IDs, genera versiones de domicilios y cierra la vigencia anterior. No modifica documentos ni solicitudes existentes. Las cuentas asociadas a operaciones no admiten cambios de identidad bancaria; registrar una cuenta nueva. Cambiar datos bancarios revoca verificación; no verifica CLABE con terceros. Los permisos existentes del perfil controlan las acciones de UI; el backend conserva el requisito superadministrador vigente. No se amplía autorización multiinstitución.

Validar en pruebas funcionales: alta con y sin relaciones; edición de la última dirección sin mutar versiones previas; alta desde modal; cambio de cuenta; cuenta vinculada; rechazo de ID ajeno y rollback; roles y paginador existente.
