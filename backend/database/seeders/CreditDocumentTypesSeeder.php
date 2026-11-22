<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditDocumentTypesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_document_types');
        DB::table('credit_document_types')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
