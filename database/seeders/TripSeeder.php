<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trips')->insert(
            [
                ['start_station_id' => 1, 'end_station_id' => 4, 'bus_id' => 1], //Cairo-Asyut
                ['start_station_id' => 1, 'end_station_id' => 8, 'bus_id' => 2], //Cairo-Mansoura
            ]
        );

        //attach some stations to trips
        DB::table('station_trip')->insert([
            //Cairo-Asyut Trip
            ['trip_id' => 1, 'station_id' => 1, 'order' => 1, 'distance_from_start_station' => 0], //cairo
            ['trip_id' => 1, 'station_id' => 2, 'order' => 2, 'distance_from_start_station' => 100], //faiyum
            ['trip_id' => 1, 'station_id' => 3, 'order' => 3, 'distance_from_start_station' => 200], //al minya
            ['trip_id' => 1, 'station_id' => 4, 'order' => 4, 'distance_from_start_station' => 300], //asyut
            //Cairo-Mansoura Trip
            ['trip_id' => 2, 'station_id' => 1, 'order' => 1, 'distance_from_start_station' => 0], //cairo
            ['trip_id' => 2, 'station_id' => 5, 'order' => 2, 'distance_from_start_station' => 50], //banha
            ['trip_id' => 2, 'station_id' => 6, 'order' => 3, 'distance_from_start_station' => 100], //tanta
            ['trip_id' => 2, 'station_id' => 7, 'order' => 4, 'distance_from_start_station' => 150], //al mahalla al kubra
            ['trip_id' => 2, 'station_id' => 8, 'order' => 5, 'distance_from_start_station' => 200], //al mansoura
        ]);
    }
}
