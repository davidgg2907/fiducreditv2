<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RecordOperationalRequest {
 public function handle(Request $request, Closure $next): mixed {
  $response = $next($request);
  $app = $request->header('X-Frontend-App');
  if (in_array($app,['originacion','administracion','pld-operacion','pld-configuracion','configuracion-sistema'],true)
      && in_array($request->method(),['POST','PUT','PATCH','DELETE'],true)
      && $response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
   DB::table('operational_request_logs')->insert([
    'actor_id'=>$request->user()->id,'frontend'=>$app,
    'operation'=>substr($request->method().' '.$request->route()->uri(),0,255),
    'http_status'=>$response->getStatusCode(),'occurred_at'=>now(),
   ]);
  }
  return $response;
 }
}