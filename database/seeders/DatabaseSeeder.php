<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CheckItemSeeder::class,
        ]);

        // Akun PIC
        \App\Models\User::create([
            'name'     => 'PPIC',
            'username' => 'pic',
            'password' => bcrypt('password123'),
            'role'     => 'pic',
            'status'   => 'active',
        ]);

        // Contoh kendaraan
        \App\Models\Vehicle::insert([
            ['plate_number' => 'B 1234 XYZ', 'type' => 'Truk Box', 'year' => 2021, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['plate_number' => 'B 5678 ABC', 'type' => 'Minibus',  'year' => 2022, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}