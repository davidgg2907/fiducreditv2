import {Injectable} from '@angular/core';
import {HttpClient,HttpParams} from '@angular/common/http';
import {map} from 'rxjs';
import {runtimeConfig} from '../../../config/runtime-config';
import {Item} from './schema';
@Injectable({providedIn:'root'}) export class ConfigApi {
 private root=runtimeConfig().appUrl;
 constructor(private http:HttpClient){}
 list(path:string,page=1,search='',filters:Record<string,string>={}){
 let params=new HttpParams().set('page',String(page)).set('per_page','25');
 if(path==='access/users'&&search)params=params.set('search',search);
 for(const [k,v] of Object.entries(filters))params=params.set(path.startsWith('access/')?k:'filter['+k+']',v);
 return this.http.get<{data:any}>(this.root+path,{params}).pipe(map(r=>{
 const data=r.data;
 if(Array.isArray(data))return {data:data as Item[],total:data.length,current_page:1,last_page:1};
 const pg=data?.meta ? {...data,...data.meta}:data;
 return {data:(pg?.data??[]) as Item[],total:pg?.total??0,current_page:pg?.current_page??1,last_page:pg?.last_page??1};
 }));
 }
 detail(path:string,id:string){return this.http.get<{data:Item}>(this.root+path+'/'+encodeURIComponent(id)).pipe(map(r=>r.data));}
 save(path:string,data:Record<string,unknown>,id?:string){return (id?this.http.put<{data:Item}>(this.root+path+'/'+encodeURIComponent(id),data):this.http.post<{data:Item}>(this.root+path,data)).pipe(map(r=>r.data));}
 remove(path:string,id:string){return this.http.delete(this.root+path+'/'+encodeURIComponent(id));}
 status(id:string,is_active:boolean){return this.http.patch(this.root+'access/users/'+encodeURIComponent(id)+'/status',{is_active});}
 catalog(){return this.http.get<{data:any[]}>(this.root+'access/catalog').pipe(map(r=>r.data));}
}
