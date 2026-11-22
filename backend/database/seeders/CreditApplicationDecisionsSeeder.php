<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationDecisionsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_decisions');
        DB::table('credit_application_decisions')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
