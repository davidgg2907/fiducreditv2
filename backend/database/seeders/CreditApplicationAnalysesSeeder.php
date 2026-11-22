<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationAnalysesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_analyses');
        DB::table('credit_application_analyses')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
