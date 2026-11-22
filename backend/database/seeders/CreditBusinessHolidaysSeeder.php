<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditBusinessHolidaysSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_business_holidays');
    }
}
