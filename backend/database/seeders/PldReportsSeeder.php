<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldReportsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_reports');
    }
}
