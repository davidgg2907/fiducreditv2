# Ajustes PR 6: vistas de configuración
- GET individual para /api/access/modules/{module}, /actions/{action}, /menus/{menu}, con la autorización manage-access heredada. Soluciona 405 en detalle/editar. La eliminación de recursos crediticios sigue bloqueada.
- El listado de acciones acepta module_id como filtro relacional.
- Catálogo de etiquetas en español; campos de relación resueltos a nombres por ReferenceLabelService con caché. Los ID se conservan para persistencia y no se usan como texto de UI.
- Paleta verde petróleo NahuiCloud, estilos de acciones, guardar, cancelar, paginador y volver; Mi perfil homogeneizado con paneles de configuración.
- Pendiente ejecutar ng build y pruebas API con BD. Evitar mostrar claves técnicas de relaciones en pantallas.
