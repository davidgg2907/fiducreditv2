# FiduCredit V2 — Originación de Crédito

Aplicación Angular independiente, copiada desde `/frontend` (arquetipo original) y adaptada para el dominio **Originación de Crédito**.

- Puerto local: **4200**
- Backend compartido: Laravel `http://localhost:8000` mediante `proxy.conf.json`.
- API: `/api/`; almacenamiento: `/storage/` (configurables en `src/assets/app-config.js`).
- Alcance: Captura, expedientes, mesa de control y análisis de solicitudes.

## Ejecución local

```bash
cd frontend-originacion
npm install
npm start
```

Comprobar: `npm run verify:archetype` y `npm run build`.

**IMPORTANTE:** este es un clon funcional de la plantilla. Todavía no se implementan módulos operativos específicos ni controles de acceso exclusivos de esta aplicación. El backend deberá validar permisos, institución y reglas por endpoint. Los cinco frontends se instalan, compilan y despliegan de forma independiente; no comparten `node_modules`.

La plantilla original `/frontend` permanece sin cambios para referencia y compatibilidad con la CI existente.
