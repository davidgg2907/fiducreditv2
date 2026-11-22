<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPenaltyAccrualsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_penalty_accruals');
    }
}
