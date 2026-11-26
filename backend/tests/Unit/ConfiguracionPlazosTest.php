<?php
namespace Tests\Unit;
use App\Models\CreditProductVersion;
use App\Services\ConfiguracionPlazos;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
final class ConfiguracionPlazosTest extends TestCase {
    public function test_incremento_y_frecuencia(): void {
        $version=new CreditProductVersion(['configuracion_plazos'=>['plazos'=>[['unidad_plazo'=>'mes','plazo_minimo'=>3,'plazo_maximo'=>12,'incremento'=>3]],'frecuencias_pago'=>['mensual'],'frecuencia_pago_predeterminada'=>'mensual']]);
        $this->assertSame(['unidad_plazo'=>'mes','frecuencia_pago'=>'mensual'],ConfiguracionPlazos::seleccionar($version,['requested_term'=>6]));
        $this->expectException(ValidationException::class);
        ConfiguracionPlazos::seleccionar($version,['requested_term'=>5]);
    }
}
