<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationConsentsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_consents');
        DB::table('credit_application_consents')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
