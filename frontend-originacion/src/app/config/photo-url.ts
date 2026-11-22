import { runtimeConfig } from './runtime-config';

/** Convierte la ruta almacenada en una URL que el navegador puede cargar. */
export function photoUrl(value: unknown): string | null {
  const path = String(value ?? '').trim();
  if (!path) return null;

  return /^(https?:|data:|blob:|\/)/.test(path) ? path : `${runtimeConfig().drive}${path}`;
}
