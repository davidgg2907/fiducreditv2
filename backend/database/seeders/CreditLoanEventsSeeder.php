<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanEventsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_events');
    }
}
