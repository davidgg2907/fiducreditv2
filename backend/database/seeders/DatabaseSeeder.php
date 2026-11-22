<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([AccessCatalogSeeder::class, RoleSeeder::class, CreditSystemMenusSeeder::class, CreditOriginacionSeeder::class, CreditWorkflowSeeder::class, CreditAdministrationSeeder::class]);
    }
}
