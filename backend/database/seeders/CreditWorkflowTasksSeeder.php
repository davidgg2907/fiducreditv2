<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowTasksSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_tasks', CreditWorkflowFixtures::rows('credit_workflow_tasks'));
    }
}
