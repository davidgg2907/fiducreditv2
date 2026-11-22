<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldMonitoringEventsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_monitoring_events');
    }
}
