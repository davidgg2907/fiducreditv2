<?php

namespace Tests\Feature;

use App\Models\CreditCompany;
use App\Models\CreditProduct;
use App\Services\CreditProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreditProductCurrentVersionTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_loads_latest_active_version_and_history(): void
    {
        $company = CreditCompany::query()->create([
            'legal_name' => 'Empresa de pruebas',
            'trade_name' => 'Pruebas',
            'rfc' => 'AAA010101AAA',
        ]);
        $product = CreditProduct::query()->create([
            'company_id' => $company->id,
            'code' => 'TEST',
            'name' => 'Producto de pruebas',
        ]);
        $terms = [
            'min_amount' => 1000, 'max_amount' => 10000,
            'min_term' => 1, 'max_term' => 12,
            'min_annual_rate' => 0.15, 'max_annual_rate' => 0.25,
        ];
        $product->creditProductVersions()->create([...$terms, 'version' => 1, 'active' => false]);
        $active = $product->creditProductVersions()->create([...$terms, 'version' => 2, 'active' => true]);
        $product->creditProductVersions()->create([...$terms, 'version' => 3, 'active' => false]);

        $detail = app(CreditProductService::class)->find($product->id);
        $this->assertSame($active->id, $detail->currentVersion->id);
        $this->assertCount(3, $detail->creditProductVersions);
        $this->assertTrue($detail->currentVersion->relationLoaded('creditProductFees'));
        $this->assertTrue($detail->currentVersion->relationLoaded('creditProductRules'));
        $this->assertTrue($detail->currentVersion->relationLoaded('creditProductFields'));
        $this->assertTrue($detail->currentVersion->relationLoaded('creditProductDocuments'));
    }
}
