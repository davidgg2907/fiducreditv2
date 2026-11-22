<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
final class LoginBrandingController extends Controller {
 public function show():JsonResponse {
  return response()->json(['data'=>['title'=>'Sistema de Recursos Humanos','logo_url'=>null]]);
 }
}
