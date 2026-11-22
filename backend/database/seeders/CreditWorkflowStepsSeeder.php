<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowStepsSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_steps', CreditWorkflowFixtures::rows('credit_workflow_steps'));
    }
}
