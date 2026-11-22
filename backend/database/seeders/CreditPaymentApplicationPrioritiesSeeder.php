<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPaymentApplicationPrioritiesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payment_application_priorities');
    }
}
