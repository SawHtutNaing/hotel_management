<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\User;
use App\Models\Meal;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create room types
        $single = RoomType::create(['name' => 'Single', 'base_price' => 80]);
        $double = RoomType::create(['name' => 'Double', 'base_price' => 150]);
        $family = RoomType::create(['name' => 'Family', 'base_price' => 250]);

        // Create 30 rooms (10 per room type)
        $roomTypes = [
            ['type' => $single, 'prefix' => 'S', 'base_price' => 80, 'image' => 'rooms/placeholder.jpg'],
            ['type' => $double, 'prefix' => 'D', 'base_price' => 150, 'image' => 'rooms/placeholder.jpg'],
            ['type' => $family, 'prefix' => 'F', 'base_price' => 250, 'image' => 'rooms/placeholder.jpg'],
        ];

        foreach ($roomTypes as $roomType) {
            for ($i = 1; $i <= 10; $i++) {
                Room::create([
                    'room_type_id' => $roomType['type']->id,
                    'room_number' => $roomType['prefix'] . sprintf('%03d', $i), // e.g., S001, D002, F003
                    'price' => $roomType['base_price'] + ($i - 1) * 5, // Slight price variation
                    'is_available' => true,
                    'image' => $roomType['image'],
                ]);
            }
        }

        // Create 10 Myanmar-inspired meals
        $meals = [
            ['name' => 'Fried Noodles', 'price' => 10.00, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Fried Rice', 'price' => 12.00, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Fried Chicken', 'price' => 15.00, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Mohinga', 'price' => 8.50, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Chicken Curry', 'price' => 14.00, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Shan Noodles', 'price' => 11.50, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Fish Soup', 'price' => 9.00, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Pork Skewers', 'price' => 13.00, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Vegetable Stir-Fry', 'price' => 7.50, 'image' => 'meals/placeholder.jpg'],
            ['name' => 'Tea Leaf Salad', 'price' => 10.50, 'image' => 'meals/placeholder.jpg'],
        ];

        foreach ($meals as $mealData) {
            Meal::create($mealData);
        }

        // Create sample bookings for testing breakfast ordering
        $room1 = Room::where('room_number', 'S001')->first();
        $room2 = Room::where('room_number', 'D001')->first();

        $booking1 = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room1->id,
            'check_in' => '2025-07-20',
            'check_out' => '2025-07-22',
            'total_price' => $room1->price * 2,
            'status' => 'confirmed',
        ]);

        $booking2 = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room2->id,
            'check_in' => '2025-07-21',
            'check_out' => '2025-07-23',
            'total_price' => $room2->price * 2,
            'status' => 'confirmed',
        ]);

        // Update room availability
        $room1->update(['is_available' => false]);
        $room2->update(['is_available' => false]);

        // Create sample breakfast orders
        $meal1 = Meal::where('name', 'Fried Noodles')->first();
        $meal2 = Meal::where('name', 'Fried Rice')->first();

        Order::create([
            'user_id' => $user->id,
            'room_id' => $room1->id,
            'meal_id' => $meal1->id,
            'quantity' => 2,
            'total_amount' => $meal1->price * 2,
            'status' => 'pending',
        ]);

        Order::create([
            'user_id' => $user->id,
            'room_id' => $room2->id,
            'meal_id' => $meal2->id,
            'quantity' => 1,
            'total_amount' => $meal2->price,
            'status' => 'confirmed',
        ]);
    }
}
