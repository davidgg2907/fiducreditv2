<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([AccessCatalogSeeder::class, RoleSeeder::class, CreditOriginacionSeeder::class, CreditWorkflowSeeder::class, CreditAdministrationSeeder::class]);
    }
}
