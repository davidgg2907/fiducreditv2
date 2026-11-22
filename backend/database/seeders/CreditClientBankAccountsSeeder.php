<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditClientBankAccountsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_client_bank_accounts');
        DB::table('credit_client_bank_accounts')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
