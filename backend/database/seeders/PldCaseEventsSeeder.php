<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldCaseEventsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_case_events');
    }
}
