<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationConditionsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_conditions');
        DB::table('credit_application_conditions')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
