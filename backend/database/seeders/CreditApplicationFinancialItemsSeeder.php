<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationFinancialItemsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_financial_items');
        DB::table('credit_application_financial_items')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
