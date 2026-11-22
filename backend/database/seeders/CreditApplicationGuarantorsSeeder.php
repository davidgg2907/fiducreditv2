<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationGuarantorsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_guarantors');
        DB::table('credit_application_guarantors')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
