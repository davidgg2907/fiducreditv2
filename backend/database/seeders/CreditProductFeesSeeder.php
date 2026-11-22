<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditProductFeesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_product_fees');
        DB::table('credit_product_fees')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
