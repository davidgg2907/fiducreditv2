<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_applications');
        DB::table('credit_applications')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
