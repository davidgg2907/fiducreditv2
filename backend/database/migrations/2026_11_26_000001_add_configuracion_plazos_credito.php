<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        Schema::create('periodos_credito', function (Blueprint $table) {
            $table->string('clave', 10)->primary();
            $table->string('nombre', 30);
        });
        DB::table('periodos_credito')->insert([
            ['clave'=>'dia','nombre'=>'Día'], ['clave'=>'semana','nombre'=>'Semana'],
            ['clave'=>'mes','nombre'=>'Mes'], ['clave'=>'anio','nombre'=>'Año'],
        ]);
        Schema::table('credit_product_versions', function (Blueprint $table) {
            $table->json('configuracion_plazos')->nullable();
        });
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->string('unidad_plazo',10)->nullable();
            $table->string('frecuencia_pago',30)->nullable();
        });
    }
    public function down(): void {
        Schema::table('credit_applications', fn (Blueprint $table) => $table->dropColumn(['unidad_plazo','frecuencia_pago']));
        Schema::table('credit_product_versions', fn (Blueprint $table) => $table->dropColumn('configuracion_plazos'));
        Schema::dropIfExists('periodos_credito');
    }
};
