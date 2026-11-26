<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([PeriodosCreditoSeeder::class, AccessCatalogSeeder::class, RoleSeeder::class, CreditSystemMenusSeeder::class, CreditAdministratorSeeder::class, CreditOriginacionSeeder::class, CreditWorkflowSeeder::class, CreditAdministrationSeeder::class]);
    }
}
