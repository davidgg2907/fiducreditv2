import {Injectable} from '@angular/core';
import {catchError,map,of,shareReplay,Observable} from 'rxjs';
import {ConfigApi} from './api.service';
import {Item,setting} from './schema';
@Injectable({providedIn:'root'}) export class ReferenceLabelService {
 private readonly requests=new Map<string,Observable<string>>();
 private readonly labels=new Map<string,string>();
 constructor(private readonly api:ConfigApi){}
 resolve(reference:string,id:unknown):void{
  if(id===null||id===undefined||id==='')return;
  const key=reference+':'+String(id);
  if(this.requests.has(key))return;
  const request=this.api.detail(setting(reference).api,String(id)).pipe(
   map(item=>this.name(reference,item)),catchError(()=>of('No disponible')),shareReplay(1)
  );
  this.requests.set(key,request);
  request.subscribe(value=>this.labels.set(key,value));
 }
 display(reference:string,id:unknown):string{
  return id===null||id===undefined||id===''?'—':this.labels.get(reference+':'+String(id))??'Consultando…';
 }
 private name(reference:string,item:Item):string{
  if(reference==='empresas')return String(item['trade_name']||item['legal_name']||'Empresa');
  if(reference==='versiones_productos'||reference==='versiones_flujos')return 'Versión '+String(item['version']??'');
  return String(item['name']||item['label']||item['code']||item['email']||'Registro');
 }
}