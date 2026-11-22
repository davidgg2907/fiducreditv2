<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationEventsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_events');
        DB::table('credit_application_events')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
