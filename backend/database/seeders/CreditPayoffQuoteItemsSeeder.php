<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPayoffQuoteItemsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payoff_quote_items');
    }
}
