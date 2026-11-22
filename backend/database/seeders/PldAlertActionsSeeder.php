<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldAlertActionsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_alert_actions');
    }
}
