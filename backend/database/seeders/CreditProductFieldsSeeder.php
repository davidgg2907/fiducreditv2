<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditProductFieldsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_product_fields');
        DB::table('credit_product_fields')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
