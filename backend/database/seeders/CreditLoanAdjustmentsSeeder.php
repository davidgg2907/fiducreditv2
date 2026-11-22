<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanAdjustmentsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_adjustments');
    }
}
