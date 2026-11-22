<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowStepRulesSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_step_rules', CreditWorkflowFixtures::rows('credit_workflow_step_rules'));
    }
}
