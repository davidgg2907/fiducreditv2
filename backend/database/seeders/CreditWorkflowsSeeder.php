<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowsSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflows', CreditWorkflowFixtures::rows('credit_workflows'));
    }
}
