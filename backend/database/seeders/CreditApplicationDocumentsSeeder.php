<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditApplicationDocumentsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_application_documents');
        DB::table('credit_application_documents')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
