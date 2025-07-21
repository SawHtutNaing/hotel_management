<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create room types
        $standard = RoomType::create(['name' => 'Standard', 'base_price' => 100]);
        $deluxe = RoomType::create(['name' => 'Deluxe', 'base_price' => 200]);

        // Create rooms
        Room::create(['room_type_id' => $standard->id, 'room_number' => '101', 'price' => 100]);
        Room::create(['room_type_id' => $deluxe->id, 'room_number' => '201', 'price' => 200]);
    }
}
