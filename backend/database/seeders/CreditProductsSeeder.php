<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditProductsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_products');
        DB::table('credit_products')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
