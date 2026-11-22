<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditWorkflowVersionsSeeder extends Seeder
{
    public function run(): void
    {
        CreditWorkflowFixtures::seed('credit_workflow_versions', CreditWorkflowFixtures::rows('credit_workflow_versions'));
    }
}
