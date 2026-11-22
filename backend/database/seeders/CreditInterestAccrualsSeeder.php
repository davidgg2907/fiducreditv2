<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditInterestAccrualsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_interest_accruals');
    }
}
