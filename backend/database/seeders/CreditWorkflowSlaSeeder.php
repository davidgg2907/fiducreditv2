<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowSlaSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_sla', CreditWorkflowFixtures::rows('credit_workflow_sla'));
    }
}
