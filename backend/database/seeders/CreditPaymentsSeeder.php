<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPaymentsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payments');
    }
}
