<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPayoffQuotesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payoff_quotes');
    }
}
