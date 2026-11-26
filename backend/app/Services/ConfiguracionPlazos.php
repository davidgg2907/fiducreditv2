<?php
namespace App\Services;
use App\Models\CreditProductVersion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
final class ConfiguracionPlazos {
    public const UNIDADES = ['dia','semana','mes','anio'];
    public const FRECUENCIAS = ['unico','diario','semanal','catorcenal','quincenal','mensual','bimestral','trimestral','cuatrimestral','semestral','anual'];
    public static function unidad(string $valor): string {
        return ['day'=>'dia','week'=>'semana','month'=>'mes','year'=>'anio'][$valor] ?? $valor;
    }
    public static function frecuencia(string $valor): string {
        return ['single'=>'unico','daily'=>'diario','weekly'=>'semanal','biweekly'=>'catorcenal','fortnightly'=>'quincenal','monthly'=>'mensual','bimonthly'=>'bimestral','quarterly'=>'trimestral','semiannual'=>'semestral','annual'=>'anual','yearly'=>'anual'][$valor] ?? $valor;
    }
    public static function validar(array $config): void {
        Validator::make($config, [
            'plazos'=>'required|array|min:1|max:4',
            'plazos.*'=>'required|array:unidad_plazo,plazo_minimo,plazo_maximo,incremento',
            'plazos.*.unidad_plazo'=>'required|distinct|in:'.implode(',',self::UNIDADES),
            'plazos.*.plazo_minimo'=>'required|integer|between:1,65535',
            'plazos.*.plazo_maximo'=>'required|integer|between:1,65535',
            'plazos.*.incremento'=>'required|integer|between:1,65535',
            'frecuencias_pago'=>'required|array|min:1|max:11',
            'frecuencias_pago.*'=>'required|distinct|in:'.implode(',',self::FRECUENCIAS),
            'frecuencia_pago_predeterminada'=>'required|string',
        ])->validate();
        foreach ($config['plazos'] as $plazo) {
            if ($plazo['plazo_maximo'] < $plazo['plazo_minimo']) throw ValidationException::withMessages(['configuracion_plazos'=>'El plazo máximo debe ser mayor o igual al mínimo.']);
        }
        if (!in_array($config['frecuencia_pago_predeterminada'],$config['frecuencias_pago'],true)) throw ValidationException::withMessages(['configuracion_plazos'=>'La frecuencia predeterminada debe estar habilitada.']);
    }
    public static function obtener(CreditProductVersion $version): array {
        if ($version->configuracion_plazos !== null) return $version->configuracion_plazos;
        $frecuencia=self::frecuencia($version->payment_frequency);
        return ['plazos'=>[['unidad_plazo'=>self::unidad($version->term_unit),'plazo_minimo'=>(int)$version->min_term,'plazo_maximo'=>(int)$version->max_term,'incremento'=>1]],'frecuencias_pago'=>[$frecuencia],'frecuencia_pago_predeterminada'=>$frecuencia];
    }
    public static function seleccionar(CreditProductVersion $version,array $datos): array {
        $config=self::obtener($version);
        $unidad=$datos['unidad_plazo'] ?? (count($config['plazos'])===1 ? $config['plazos'][0]['unidad_plazo'] : null);
        $frecuencia=$datos['frecuencia_pago'] ?? (count($config['frecuencias_pago'])===1 ? $config['frecuencias_pago'][0] : null);
        $cantidad=(int)($datos['requested_term']??0);
        foreach ($config['plazos'] as $plazo) {
            if ($unidad===$plazo['unidad_plazo'] && $cantidad >= $plazo['plazo_minimo'] && $cantidad <= $plazo['plazo_maximo'] && ($cantidad-$plazo['plazo_minimo']) % $plazo['incremento']===0 && in_array($frecuencia,$config['frecuencias_pago'],true)) return ['unidad_plazo'=>$unidad,'frecuencia_pago'=>$frecuencia];
        }
        throw ValidationException::withMessages(['requested_term'=>'Seleccione un plazo y frecuencia autorizados para la versión del producto.']);
    }
}
