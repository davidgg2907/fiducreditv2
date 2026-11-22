# FiduCredit V2 — Operación PLD

Aplicación Angular independiente, copiada desde `/frontend` (arquetipo original) y adaptada para el dominio **Operación PLD**.

- Puerto local: **4202**
- Backend compartido: Laravel `http://localhost:8000` mediante `proxy.conf.json`.
- API: `/api/`; almacenamiento: `/storage/` (configurables en `src/assets/app-config.js`).
- Alcance: Monitoreo, alertas, investigaciones y casos PLD/FT.

## Ejecución local

```bash
cd frontend-pld-operacion
npm install
npm start
```

Comprobar: `npm run verify:archetype` y `npm run build`.

**IMPORTANTE:** este es un clon funcional de la plantilla. Todavía no se implementan módulos operativos específicos ni controles de acceso exclusivos de esta aplicación. El backend deberá validar permisos, institución y reglas por endpoint. Los cinco frontends se instalan, compilan y despliegan de forma independiente; no comparten `node_modules`.

La plantilla original `/frontend` permanece sin cambios para referencia y compatibilidad con la CI existente.
