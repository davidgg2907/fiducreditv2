export const SYSTEMS = [
 {code:'originacion',name:'Originación'},
 {code:'administracion',name:'Administración de créditos'},
 {code:'pld-operacion',name:'PLD Operación'},
 {code:'pld-configuracion',name:'PLD Configuración'},
 {code:'configuracion-sistema',name:'Configuración del sistema'}
];
export function systemOf(key:string):string {
 return SYSTEMS.find(s=>key.startsWith('credit_'+s.code+'_'))?.code ?? '';
}
export function roleSystems(permissions:unknown):string[] {
 return Array.isArray(permissions)?SYSTEMS.filter(s=>permissions.some(p=>typeof p==='string'&&systemOf(p)===s.code)).map(s=>s.code):[];
}
