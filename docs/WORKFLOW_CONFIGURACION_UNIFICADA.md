# Configuración unificada de workflow

El formulario de Flujos reúne información general y etapas. Las etapas se agregan localmente, se ordenan por arrastre o flechas y se editan mediante modales independientes de información, reglas y roles. Aceptar en el modal no escribe en base de datos. Guardar envía un único POST o PUT al recurso credit-workflows.

El arreglo steps determina sort_order (1..N). El servidor crea una versión borrador, conserva las versiones anteriores y copia las transiciones y SLA existentes remapeando identificadores. source_version_id protege contra guardados concurrentes. Las reglas vinculadas a transiciones se remapean y se valida su pertenencia. No se publica automáticamente; el orden no implica transiciones automáticas. El motor de ejecución y publicación queda fuera de este cambio. Las rutas administrativas existentes permanecen disponibles por compatibilidad.
