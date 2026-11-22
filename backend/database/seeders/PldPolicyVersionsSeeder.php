<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldPolicyVersionsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_policy_versions');
    }
}
