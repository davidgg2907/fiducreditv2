import {Injectable} from '@angular/core';
import {AuthService} from '../../../servicios/auth/auth.service';
import {ModuleConfig} from './schema';
@Injectable({providedIn:'root'}) export class ConfigPermissions {
 constructor(private auth:AuthService){}
 can(m:ModuleConfig,action:'ver'|'detalle'|'crear'|'editar'|'eliminar'):boolean{
 const u=this.auth.user();return !!u&&(!!u.isAdmin || (u.permissions??[]).includes(m.permission+'.'+action));
 }
}
