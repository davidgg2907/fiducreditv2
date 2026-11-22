<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PldClientProfilesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('pld_client_profiles');
    }
}
