<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditAdvisorsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_advisors');
        DB::table('credit_advisors')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
