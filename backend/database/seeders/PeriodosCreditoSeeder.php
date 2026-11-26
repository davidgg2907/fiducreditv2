<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
final class PeriodosCreditoSeeder extends Seeder {
    public function run(): void {
        foreach (['dia'=>'Día','semana'=>'Semana','mes'=>'Mes','anio'=>'Año'] as $clave=>$nombre) {
            DB::table('periodos_credito')->updateOrInsert(['clave'=>$clave], ['nombre'=>$nombre]);
        }
    }
}
