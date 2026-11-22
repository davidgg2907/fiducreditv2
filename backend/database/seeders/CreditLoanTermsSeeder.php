<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanTermsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_terms');
    }
}
