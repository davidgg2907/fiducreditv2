<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanRateRevisionsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_rate_revisions');
    }
}
