<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditDelinquencySnapshotsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_delinquency_snapshots');
    }
}
