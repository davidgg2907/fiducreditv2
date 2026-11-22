<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditCustomFieldsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_custom_fields');
        DB::table('credit_custom_fields')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
