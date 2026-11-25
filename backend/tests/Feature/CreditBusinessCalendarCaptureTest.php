<?php

namespace Tests\Feature;

use App\Models\CreditCompany;
use App\Services\CreditBusinessCalendarService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

final class CreditBusinessCalendarCaptureTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_and_holidays_are_saved_together_and_edits_preserve_identity(): void
    {
        $company = CreditCompany::query()->create(['legal_name'=>'Pruebas','trade_name'=>'Pruebas','rfc'=>'AAA010101AAA']);
        $service = app(CreditBusinessCalendarService::class);
        $calendar = $service->create(['company_id'=>$company->id,'code'=>'TEST','name'=>'Calendario','timezone'=>'America/Mexico_City','non_business_weekdays'=>[0,6],
            'holidays'=>[['holiday_date'=>'2026-12-25','description'=>'Navidad','recurring'=>true]]]);
        $holiday = $calendar->creditBusinessHolidays->sole();
        $updated = $service->update($calendar->id, ['name'=>'Actualizado','holidays'=>[
            ['id'=>$holiday->id,'holiday_date'=>'2026-12-25','description'=>'Cierre navideño','recurring'=>true],
            ['holiday_date'=>'2026-12-31','description'=>'Cierre anual','recurring'=>false],
        ]]);
        $this->assertCount(2, $updated->creditBusinessHolidays);
        $this->assertDatabaseHas('credit_business_holidays',['id'=>$holiday->id,'description'=>'Cierre navideño']);
        try {
            $service->update($calendar->id, ['name'=>'No debe persistir','holidays'=>[
                ['holiday_date'=>'2026-12-25','description'=>'Duplicado','recurring'=>false],
            ]]);
            $this->fail('Debe rechazar la fecha duplicada.');
        } catch (ValidationException $e) {
            $this->assertDatabaseHas('credit_business_calendars',['id'=>$calendar->id,'name'=>'Actualizado']);
            $this->assertCount(2, $service->find($calendar->id)->creditBusinessHolidays);
        }
        $service->update($calendar->id,['holidays'=>[]]);
        $this->assertCount(2, $service->find($calendar->id)->creditBusinessHolidays);
    }
}
