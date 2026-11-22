export interface RuntimeConfig {
  appUrl: string;
  drive: string;
  isProduction: boolean;
  /** Clave pública de Maps Embed API, restringida por referer en Google Cloud. Opcional. */
  googleMapsEmbedApiKey?: string;
}

declare global {
  interface Window { __appConfig__?: Partial<RuntimeConfig>; }
}

function normalizeUrl(value: string | undefined, fallback: string): string {
  const url = value?.trim() || fallback;
  return url.endsWith('/') ? url : `${url}/`;
}

/** Configuración de ejecución: se toma de assets/app-config.js, sin recompilar Angular. */
export function runtimeConfig(): RuntimeConfig {
  const config = window.__appConfig__ ?? {};
  return {
    appUrl: normalizeUrl(config.appUrl, '/api/'),
    drive: normalizeUrl(config.drive, ''),
    isProduction: Boolean(config.isProduction),
    googleMapsEmbedApiKey: (config.googleMapsEmbedApiKey ?? '').trim(),
  };
}
