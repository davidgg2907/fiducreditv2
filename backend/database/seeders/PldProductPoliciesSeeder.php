<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldProductPoliciesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_product_policies');
    }
}
