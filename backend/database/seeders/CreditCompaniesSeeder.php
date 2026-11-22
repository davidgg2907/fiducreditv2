<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditCompaniesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_companies');
        DB::table('credit_companies')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
