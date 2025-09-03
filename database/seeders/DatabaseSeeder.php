<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\User;
use App\Models\Meal;
use App\Models\Booking;
use App\Models\Order;
use App\Models\FoodCategory;
use App\Models\FloorType;
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

        // User::factory(10)->create();

        // Create room types
        $single = RoomType::create(['name' => 'Single', 'base_price' => 80, 'service' => 'Daily housekeeping']);
        $double = RoomType::create(['name' => 'Double', 'base_price' => 150, 'service' => 'Daily housekeeping, free Wi-Fi']);
        $family = RoomType::create(['name' => 'Family', 'base_price' => 250, 'service' => 'Daily housekeeping, free Wi-Fi, complimentary breakfast']);

        // Create floor types
        $floor1 = FloorType::create(['name' => 'First Floor', 'description' => 'Close to the lobby and restaurant']);
        $floor2 = FloorType::create(['name' => 'Second Floor', 'description' => 'Quiet and with a good view']);
        $floor3 = FloorType::create(['name' => 'Third Floor', 'description' => 'Executive floor with premium amenities']);

        // Create 30 rooms (10 per room type)
        $roomTypes = [
            ['type' => $single, 'prefix' => 'S', 'base_price' => 80, 'image' => 'rooms/placeholder.jpg'],
            ['type' => $double, 'prefix' => 'D', 'base_price' => 150, 'image' => 'rooms/placeholder.jpg'],
            ['type' => $family, 'prefix' => 'F', 'base_price' => 250, 'image' => 'rooms/placeholder.jpg'],
        ];

        $floorTypes = [$floor1, $floor2, $floor3];

        foreach ($roomTypes as $roomType) {
            for ($i = 1; $i <= 10; $i++) {
                Room::create([
                    'room_type_id' => $roomType['type']->id,
                    'floor_type_id' => $floorTypes[array_rand($floorTypes)]->id,
                    'room_number' => $roomType['prefix'] . sprintf('%03d', $i), // e.g., S001, D002, F003
                    'price' => $roomType['base_price'] + ($i - 1) * 5, // Slight price variation
                    'is_available' => true,
                    'image' => $roomType['image'],
                ]);
            }
        }

        // Create food categories
        $cat1 = FoodCategory::create(['name' => 'Appetizers', 'description' => 'Light bites to start your meal']);
        $cat2 = FoodCategory::create(['name' => 'Main Courses', 'description' => 'Hearty and delicious main dishes']);
        $cat3 = FoodCategory::create(['name' => 'Desserts', 'description' => 'Sweet treats to end your meal']);
        $cat4 = FoodCategory::create(['name' => 'Beverages', 'description' => 'Refreshing drinks']);

        // Create 10 Myanmar-inspired meals
        $meals = [
            ['name' => 'Fried Noodles', 'price' => 10.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat2->id],
            ['name' => 'Fried Rice', 'price' => 12.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat2->id],
            ['name' => 'Fried Chicken', 'price' => 15.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat2->id],
            ['name' => 'Mohinga', 'price' => 8.50, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat2->id],
            ['name' => 'Chicken Curry', 'price' => 14.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat2->id],
            ['name' => 'Shan Noodles', 'price' => 11.50, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat2->id],
            ['name' => 'Fish Soup', 'price' => 9.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat1->id],
            ['name' => 'Pork Skewers', 'price' => 13.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat1->id],
            ['name' => 'Vegetable Stir-Fry', 'price' => 7.50, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat1->id],
            ['name' => 'Tea Leaf Salad', 'price' => 10.50, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat1->id],
            ['name' => 'Chocolate Cake', 'price' => 6.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat3->id],
            ['name' => 'Ice Cream', 'price' => 4.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat3->id],
            ['name' => 'Coke', 'price' => 2.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat4->id],
            ['name' => 'Orange Juice', 'price' => 3.00, 'image' => 'meals/placeholder.jpg', 'food_category_id' => $cat4->id],
        ];

        foreach ($meals as $mealData) {
            Meal::create($mealData);
        }

        // Create sample bookings for testing food ordering
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

        // Create sample food orders
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

