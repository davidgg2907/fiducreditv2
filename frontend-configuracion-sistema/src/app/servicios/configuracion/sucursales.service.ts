import {Injectable} from '@angular/core';
import {ConfigApi} from '../../modules/configuracion/shared/api.service';
import {setting} from '../../modules/configuracion/shared/schema';
@Injectable({providedIn:'root'}) export class SucursalesService {
 readonly module=setting('sucursales');
 constructor(private api:ConfigApi){}
 list(page=1,search=''){return this.api.list(this.module.api,page,search);}
 detail(id:string){return this.api.detail(this.module.api,id);}
 save(data:Record<string,unknown>,id?:string){return this.api.save(this.module.api,data,id);}
 remove(id:string){return this.api.remove(this.module.api,id);}
}