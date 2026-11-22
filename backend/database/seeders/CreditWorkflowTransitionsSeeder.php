<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowTransitionsSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_transitions', CreditWorkflowFixtures::rows('credit_workflow_transitions'));
    }
}
