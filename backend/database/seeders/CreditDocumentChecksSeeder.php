<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditDocumentChecksSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_document_checks');
        DB::table('credit_document_checks')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
