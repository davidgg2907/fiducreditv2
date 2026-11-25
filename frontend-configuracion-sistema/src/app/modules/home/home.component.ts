import {Component,OnInit} from '@angular/core';
import {CommonModule} from '@angular/common';
import {HttpClient} from '@angular/common/http';
import {MatModule} from 'src/app/appModules/mat.module';
import {runtimeConfig} from '../../config/runtime-config';
interface Column {key:string; label:string}
interface Panel {title:string; columns:Column[]; rows:Record<string,unknown>[]}
interface Snapshot {online:Record<string,unknown>[];sessions:Record<string,unknown>[];applications:Record<string,unknown>[];logs:Record<string,Record<string,unknown>[]>;generated_at:string}
@Component({selector:'app-home',standalone:true,imports:[CommonModule,MatModule],templateUrl:'./home.component.html',styleUrls:['./home.component.scss']})
export class HomeComponent implements OnInit {
 data:Snapshot|null=null; loading=false; error='';
 readonly names:Record<string,string>={'originacion':'Originación','administracion':'Administración de Créditos','pld-operacion':'Operación PLD','pld-configuracion':'Configuración PLD','configuracion-sistema':'Configuración del Sistema'};
 constructor(private http:HttpClient){}
 ngOnInit(){this.refresh();}
 refresh(){if(this.loading)return;this.loading=true;this.error='';this.http.get<{data:Snapshot}>(runtimeConfig().appUrl+'access/operational-dashboard').subscribe({next:r=>{this.data=r.data;this.loading=false;},error:e=>{this.loading=false;this.error=e.status===403?'No tienes autorización para consultar este panel.':'No fue posible consultar los indicadores.';}});}
 private cols(entries:Record<string,string>):Column[]{return Object.entries(entries).map(([key,label])=>({key,label}));}
 get panels():Panel[]{const d=this.data;if(!d)return [];return [
 {title:'Usuarios en línea (sesión vigente)',columns:this.cols({name:'Usuario',role:'Rol',last_activity_at:'Última actividad',expires_at:'Vencimiento'}),rows:d.online},
 {title:'Últimas 20 sesiones',columns:this.cols({user_name:'Usuario',frontend:'Sistema',started_at:'Fecha y hora'}),rows:d.sessions},
 {title:'Últimas 20 solicitudes',columns:this.cols({application_number:'Folio',client:'Cliente',product:'Producto',requested_amount:'Monto solicitado',status:'Estado',created_at:'Fecha y hora'}),rows:d.applications}
 ];}
 get logPanels():Panel[]{return Object.entries(this.data?.logs??{}).map(([key,rows])=>({title:this.names[key]??key,rows,columns:this.cols({occurred_at:'Fecha y hora',operation:'Transacción / evento',client:'Cliente',reference:'Folio / crédito / caso',actor:'Usuario',source:'Origen'})}));}
 value(row:Record<string,unknown>,key:string):string{return String(row[key]??'—');}
}