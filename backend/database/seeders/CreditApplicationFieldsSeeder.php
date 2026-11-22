<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationFieldsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_fields');
        DB::table('credit_application_fields')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
