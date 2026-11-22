<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationStatusHistorySeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_status_history');
        DB::table('credit_application_status_history')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
