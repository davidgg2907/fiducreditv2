<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditAmortizationSchedulesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_amortization_schedules');
    }
}
