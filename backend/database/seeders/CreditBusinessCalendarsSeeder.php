<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditBusinessCalendarsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_business_calendars');
    }
}
