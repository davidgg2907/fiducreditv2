<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditAmortizationInstallmentsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_amortization_installments');
    }
}
