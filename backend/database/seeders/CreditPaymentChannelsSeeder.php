<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPaymentChannelsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payment_channels');
    }
}
