<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        for ($i = 0; $i < 5; $i++) {
            $users[] = [
                'name' => Str::random(10),
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ];
        }

        DB::table('users')->insert($users);
    }
}
