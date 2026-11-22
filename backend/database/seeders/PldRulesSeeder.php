<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldRulesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_rules');
    }
}
