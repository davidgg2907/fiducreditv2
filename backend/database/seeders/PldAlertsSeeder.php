<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldAlertsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_alerts');
    }
}
