# Originación — pantallas iniciales

Los 14 módulos del menú tienen list, form y detail con archivos TS/HTML/SCSS explícitos, servicio e interfaz propios. Las rutas usan los permisos del perfil y el interceptor existente. No se cambia la autorización de Laravel ni se activa DELETE.

Los módulos de documentos, expedientes, mesa de control, tareas y dictámenes son de consulta: las operaciones compuestas o de negocio no se simulan. Consentimientos permite alta, no reescritura desde la UI. Domicilios administra el registro padre; captura de versiones queda pendiente de integrar. Solicitudes captura el borrador básico, sin archivos ni arreglos financieros en el mismo formulario todavía. Consultas de buró captura registros, no consulta proveedores. Los filtros son exactos según API. Los selectores cargan páginas del catálogo. No se considera listo para producción: faltan reglas de negocio, permisos efectivos por institución/sucursal y pruebas funcionales.
