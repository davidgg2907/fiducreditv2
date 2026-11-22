<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLinesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_lines');
    }
}
