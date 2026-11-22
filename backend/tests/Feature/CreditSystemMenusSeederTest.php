<?php

namespace Tests\Feature;

use App\Services\SessionMenu;
use Database\Seeders\AccessCatalogSeeder;
use Database\Seeders\CreditSystemMenusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class CreditSystemMenusSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_is_idempotent_and_each_module_has_five_actions(): void
    {
        $this->seed(AccessCatalogSeeder::class);
        $this->seed(CreditSystemMenusSeeder::class);
        $moduleCount = DB::table('access_modules')->count();
        $actionCount = DB::table('module_actions')->count();
        $menuCount = DB::table('menu_items')->count();

        $this->seed(CreditSystemMenusSeeder::class);
        $this->assertSame($moduleCount, DB::table('access_modules')->count());
        $this->assertSame($actionCount, DB::table('module_actions')->count());
        $this->assertSame($menuCount, DB::table('menu_items')->count());

        foreach (DB::table('access_modules')->where('code', 'like', 'credit_%')->get() as $module) {
            $this->assertSame(5, DB::table('module_actions')->where('module_id', $module->id)->count());
        }
    }

    public function test_menu_is_isolated_by_frontend_and_filtered_by_permissions(): void
    {
        $this->seed(AccessCatalogSeeder::class);
        $this->seed(CreditSystemMenusSeeder::class);
        $service = app(SessionMenu::class);

        $menu = $service->forPermissions(['credit_originacion_clientes.ver'], false, 'originacion');
        $flatten = function (array $items) use (&$flatten): array {
            $codes = [];
            foreach ($items as $item) {
                $codes[] = $item['code'];
                $codes = [...$codes, ...$flatten($item['children'] ?? [])];
            }
            return $codes;
        };
        $codes = $flatten($menu);
        $this->assertContains('credit_originacion_clientes', $codes);
        $this->assertNotContains('credit_administracion_creditos', $codes);
        $this->assertNotContains('credit_pld-operacion_alertas_pld', $codes);

        $adminMenu = $service->forPermissions([], true, 'configuracion-sistema');
        $adminCodes = $flatten($adminMenu);
        $this->assertContains('credit_configuracion-sistema_usuarios', $adminCodes);
        $this->assertNotContains('credit_originacion_clientes', $adminCodes);
    }
}
