<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditDrawdownsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_drawdowns');
    }
}
