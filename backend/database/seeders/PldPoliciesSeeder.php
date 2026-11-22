<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldPoliciesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_policies');
    }
}
