# FiduCredit V2 — Administración de Créditos

Aplicación Angular independiente, copiada desde `/frontend` (arquetipo original) y adaptada para el dominio **Administración de Créditos**.

- Puerto local: **4201**
- Backend compartido: Laravel `http://localhost:8000` mediante `proxy.conf.json`.
- API: `/api/`; almacenamiento: `/storage/` (configurables en `src/assets/app-config.js`).
- Alcance: Líneas de crédito, cartera, amortizaciones, pagos y liquidaciones.

## Ejecución local

```bash
cd frontend-administracion
npm install
npm start
```

Comprobar: `npm run verify:archetype` y `npm run build`.

**IMPORTANTE:** este es un clon funcional de la plantilla. Todavía no se implementan módulos operativos específicos ni controles de acceso exclusivos de esta aplicación. El backend deberá validar permisos, institución y reglas por endpoint. Los cinco frontends se instalan, compilan y despliegan de forma independiente; no comparten `node_modules`.

La plantilla original `/frontend` permanece sin cambios para referencia y compatibilidad con la CI existente.
