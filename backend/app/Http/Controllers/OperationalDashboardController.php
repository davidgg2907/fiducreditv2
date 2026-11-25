<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\OperationalDashboardService;
class OperationalDashboardController extends Controller {
 public function index(Request $request, OperationalDashboardService $service) {
  return response()->json(['data'=>$service->snapshot(in_array('pld-data.view',$request->user()->permissions(),true))])->header('Cache-Control','no-store');
 }
}