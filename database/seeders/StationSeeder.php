<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stations')->insert([
            ['name' => 'Cairo'],
            ['name' => 'Faiyum'],
            ['name' => 'Al Minya'],
            ['name' => 'Asyut'],
            ['name' => 'Banha'],
            ['name' => 'Tanta'],
            ['name' => 'Al Mahalla Al Kubra'],
            ['name' => 'Al Mansoura'],
        ]);
    }
}
