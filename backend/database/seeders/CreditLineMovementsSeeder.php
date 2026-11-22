<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLineMovementsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_line_movements');
    }
}
