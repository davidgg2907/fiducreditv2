<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationFinancialSummariesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_financial_summaries');
        DB::table('credit_application_financial_summaries')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
