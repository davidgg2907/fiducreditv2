<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldBeneficialOwnersSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_beneficial_owners');
    }
}
