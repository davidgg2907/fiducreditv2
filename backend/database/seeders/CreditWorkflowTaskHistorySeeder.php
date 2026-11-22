<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowTaskHistorySeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_task_history', CreditWorkflowFixtures::rows('credit_workflow_task_history'));
    }
}
