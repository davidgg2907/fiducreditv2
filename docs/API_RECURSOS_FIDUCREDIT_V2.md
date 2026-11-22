# FiduCredit V2 — API transaccional independiente por entidad

## Arquitectura adoptada

El backend Laravel es único para los cinco frontends Angular y la base de datos compartida. No utiliza `DomainResourceController`, `DomainCrudService` ni `DomainWriteRequest` como CRUD genéricos.

Cada una de las 83 entidades tiene archivos independientes en las carpetas raíz existentes:

- `backend/app/Http/Controllers/{Entidad}Controller.php`: métodos HTTP explícitos `index`, `show`, `store`, `update`, `destroy`.
- `backend/app/Http/Requests/Store{Entidad}Request.php` y `Update{Entidad}Request.php`: validaciones por columna, basadas en migraciones, que evolucionarán según cada flujo.
- `backend/app/Http/Resources/{Entidad}Resource.php`: representación de respuesta; personalizar según visibilidad de datos y cada audiencia.
- `backend/app/Models/{Entidad}.php`: entidad y asociaciones Eloquent.
- `backend/app/Services/{Entidad}Service.php`: lógica de coordinación, transacciones y evolución de reglas por caso de uso.
- `backend/app/Repositories/{Entidad}Repository.php`: persistencia Eloquent, consultas paginadas y relaciones, separadas del HTTP.

**No se generan reglas de negocio ficticias.** En futuras etapas, cada servicio coordinará reglas especializadas y repositorios en transacciones atómicas; pueden incorporarse componentes `Business` o acciones independientes cuando el proceso lo justifique.

## Rutas de API

El prefijo sigue siendo `/api/v1`. Los 83 recursos mantienen los nombres `credit-...` y `pld-...`, y parámetros cortos `{id}` compatibles con Symfony. El CRUD base permite consultas y algunas escrituras administrativas; no habilita por sí mismo los procesos financieros.

- `GET /api/v1/credit-clients?per_page=25&filter[company_id]={uuid}`
- `GET /api/v1/credit-applications/{id}?include=creditApplicationDocuments,creditApplicationFinancialItems`
- `POST /api/v1/credit-applications`: captura compuesta de un **borrador**, sus conceptos financieros, consentimientos y archivos.
- `POST /api/v1/credit-applications/{id}/financial-items/batch`: uno o varios conceptos, hasta 200, con una transacción SQL y control de estado.
- `POST /api/v1/credit-application-financial-items`: captura individual, asociada a la solicitud.

## Captura compuesta de solicitudes

`POST /api/v1/credit-applications` acepta **multipart/form-data** cuando hay archivos y permite arreglos anidados:

- Campos de la tabla `credit_applications`: cliente, producto, asesor, sucursal, versión de domicilio, monto, plazo, folio y datos declarados.
- `financial_items[n][entry_type|concept|amount|frequency|...]`.
- `documents[n][document_type_id]` y `documents[n][file]` (archivo real, máximo 10 MiB).
- `consents[n][consent_type|version|accepted]`.

El servicio abre una transacción, crea la solicitud, inserta conceptos, guarda archivos en disco privado, versiona los documentos de esa nueva solicitud, registra consentimientos y un evento de auditoría, y devuelve el expediente con relaciones. En caso de rollback elimina los archivos recién creados. `created_by`, `captured_by` y `uploaded_by` se toman del usuario autenticado, no del JSON enviado por el cliente.

**Limitaciones:** la operación crea una solicitud en estado `captured`; no la autoriza ni la presenta al workflow. El versionado posterior de documentos, la verificación bancaria/KYC y el almacenamiento de evidencias regulatorias siguen pendientes de su respectivo caso de uso.

## Captura masiva

`POST /api/v1/credit-applications/{id}/financial-items/batch`:

```json
{
  "items": [
    {
      "entry_type": "income",
      "concept": "Sueldo",
      "amount": "25000.00",
      "frequency": "monthly"
    },
    {
      "entry_type": "expense",
      "concept": "Renta",
      "amount": "6000.00",
      "frequency": "monthly"
    }
  ]
}
```

Se valida la colección y se registra con un solo `INSERT` de múltiples filas dentro de una transacción. Se bloquea la solicitud mediante `lockForUpdate` y se verifica que siga en captura. No se pueden modificar solicitudes autorizadas mediante esta operación.

## Seguridad

- Todas las rutas están autenticadas mediante el middleware de token existente.
- Por ahora, se exige `is_superadmin` para consumir estos recursos. Los módulos operativos por empresa/sucursal y los perfiles separados aún requieren autorización propia.
- PLD requiere además permisos `pld-data.view` y `pld-data.write`.
- No se admiten borrados físicos: `DELETE` devuelve 405.
- Las escrituras directas sobre movimientos financieros, saldos, historiales, workflow runtime y otros recursos de alto riesgo permanecen bloqueadas (405). Sus futuras operaciones deberán pasar por servicios de negocio específicos.
- Se restringió la escritura directa de documentos del expediente para evitar referencias arbitrarias a rutas de almacenamiento y sobreescritura del historial.

## Validación y requisitos pendientes

- Las reglas de `FormRequest` son estructurales; no sustituyen verificación multiinstitución, identidad, límites financieros, KYC, segregación de funciones ni controles PLD.
- Versiones publicadas de productos, reglas y flujos requieren políticas de inmutabilidad antes del uso productivo.
- Falta reforzar autorización y filtrado por compañía/sucursal, visibilidad de campos sensibles, auditoría de cada modificación, validación cruzada de relaciones y límites por estado.
- Los repositorios actuales permiten ordenar por columnas físicas con validación de columnas existentes. Se deben definir índices y filtros propios de cada caso de uso para producción.
- La entrega incluye una prueba estructural de que todos los controladores declaran sus métodos y tienen modelos, servicios, repositorios y requests propios; GitHub Actions verifica sintaxis y rutas.

**No ejecutar procesos reales de crédito, pago, dispersión, liquidación o reporte regulatorio usando solamente este andamiaje.** No se han implementado todavía las reglas financieras ni la autorización operativa definitiva.
