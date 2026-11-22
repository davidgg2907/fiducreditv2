<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditDocumentValidationRulesSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_document_validation_rules');
        DB::table('credit_document_validation_rules')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
