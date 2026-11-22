<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowInstancesSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_instances', CreditWorkflowFixtures::rows('credit_workflow_instances'));
    }
}
