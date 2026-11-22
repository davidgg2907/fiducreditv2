<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class CreditLoanLedgerEntriesSeeder extends Seeder
{
    public function run(): void
    {
        CreditAdministrationFixtures::seed('credit_loan_ledger_entries');
    }
}
