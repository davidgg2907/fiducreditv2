<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditProductCalendarsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_product_calendars');
    }
}
