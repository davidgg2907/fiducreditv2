<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CreditWorkflowsSeeder::class,
            CreditWorkflowVersionsSeeder::class,
            CreditWorkflowStepsSeeder::class,
            CreditWorkflowTransitionsSeeder::class,
            CreditWorkflowStepRolesSeeder::class,
            CreditWorkflowStepRulesSeeder::class,
            CreditWorkflowInstancesSeeder::class,
            CreditWorkflowTasksSeeder::class,
            CreditWorkflowTaskHistorySeeder::class,
            CreditWorkflowSlaSeeder::class,
        ]);
    }
}
