<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CreditClientsSeeder extends Seeder {
    public function run(): void {
        $row = CreditOriginacionFixtures::rows('credit_clients');
        DB::table('credit_clients')->updateOrInsert(['id'=>$row['id']], $row);
    }
}
