<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldCasesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_cases');
    }
}
