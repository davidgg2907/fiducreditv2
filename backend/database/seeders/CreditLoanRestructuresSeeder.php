<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanRestructuresSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_restructures');
    }
}
