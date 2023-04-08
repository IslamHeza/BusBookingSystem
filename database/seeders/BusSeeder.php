<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create bus 1
        $bus1 = Bus::create([
            'name' => 'Bus 1',
            'plate_number' => 'ABC-123',
            'number_of_seats' => 12,
        ]);

        // Create bus 2
        $bus2 = Bus::create([
            'name' => 'Bus 2',
            'plate_number' => 'DEF-456',
            'number_of_seats' => 12,
        ]);

        // Create seats for bus 1
        for ($i = 1; $i <= $bus1->number_of_seats; $i++) {
            Seat::create([
                'bus_id' => $bus1->id,
                'name' =>  $i,
            ]);
        }

        // Create seats for bus 2
        for ($i = 1; $i <= $bus2->number_of_seats; $i++) {
            Seat::create([
                'bus_id' => $bus2->id,
                'name' => $i,
            ]);
        }
    }
}
