<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLinePoliciesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_line_policies');
    }
}
