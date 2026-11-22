<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditPaymentAllocationsSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_payment_allocations');
    }
}
