declare global {
  interface Window {
    __appConfig__?: {
      appUrl?: string;
      drive?: string;
      idleTimeoutMinutes?: number;
      isProduction?: boolean;
      googleMapsEmbedApiKey?: string;
    };
  }
}

const runtimeConfig = window.__appConfig__ ?? {};

export const environment = {
  appUrl: runtimeConfig.appUrl ?? '/api/',
  drive: runtimeConfig.drive ?? '/storage/',
  idleTimeoutMinutes: runtimeConfig.idleTimeoutMinutes ?? 90,
  isProduction: runtimeConfig.isProduction ?? true,
};
 
