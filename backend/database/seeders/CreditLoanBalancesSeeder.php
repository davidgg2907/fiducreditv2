<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanBalancesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_balances');
    }
}
