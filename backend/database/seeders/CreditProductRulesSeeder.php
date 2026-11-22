<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditProductRulesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_product_rules');
        DB::table('credit_product_rules')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
