<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditProductDocumentsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_product_documents');
        DB::table('credit_product_documents')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
