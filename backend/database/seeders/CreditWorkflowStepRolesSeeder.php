<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowStepRolesSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_step_roles', CreditWorkflowFixtures::rows('credit_workflow_step_roles'));
    }
}
