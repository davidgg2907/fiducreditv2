<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditBranchesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_branches');
        DB::table('credit_branches')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
