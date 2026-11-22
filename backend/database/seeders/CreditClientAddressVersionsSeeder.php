<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditClientAddressVersionsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_client_address_versions');
        DB::table('credit_client_address_versions')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
