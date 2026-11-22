<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditClientAddressesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_client_addresses');
        DB::table('credit_client_addresses')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
