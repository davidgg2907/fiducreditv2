<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLineLimitHistorySeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_line_limit_history');
    }
}
