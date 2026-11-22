<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoansSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loans');
    }
}
