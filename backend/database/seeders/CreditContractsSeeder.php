<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditContractsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_contracts');
    }
}
