<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditBureauInquiriesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_bureau_inquiries');
        DB::table('credit_bureau_inquiries')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
