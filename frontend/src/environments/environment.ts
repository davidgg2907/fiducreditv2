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
  appUrl: runtimeConfig.appUrl ?? 'https://postapi.nahuicloud-ing.com/api/',
  drive: runtimeConfig.drive ?? 'https://postapi.nahuicloud-ing.com/storage/',
  idleTimeoutMinutes: runtimeConfig.idleTimeoutMinutes ?? 90,
  isProduction: runtimeConfig.isProduction ?? true,
};
 
