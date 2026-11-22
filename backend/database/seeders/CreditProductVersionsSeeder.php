<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditProductVersionsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_product_versions');
        DB::table('credit_product_versions')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
