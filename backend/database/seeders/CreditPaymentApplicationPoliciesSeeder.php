<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPaymentApplicationPoliciesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payment_application_policies');
    }
}
