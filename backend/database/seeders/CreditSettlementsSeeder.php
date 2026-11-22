<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditSettlementsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_settlements');
    }
}
