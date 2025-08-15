<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/booking-history', \App\Livewire\BookingHistory::class)->name('booking.history');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/food-order', \App\Livewire\FoodOrder::class)->name('food.order');
    Route::get('/order-history', \App\Livewire\OrderHistory::class)->name('order_history');


Route::get('/booking-history', \App\Livewire\BookingHistory::class)->name('booking.history');
   Route::get('/rooms', \App\Livewire\RoomSearch::class)->name('rooms.search');
    Route::get('/booking/{roomId}', \App\Livewire\BookingForm::class)->name('booking.form');
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/room-types', \App\Livewire\Admin\RoomTypeManager::class)->name('admin.room-types');
    Route::get('/rooms', \App\Livewire\Admin\RoomManager::class)->name('admin.rooms');
    Route::get('/bookings', \App\Livewire\Admin\BookingManager::class)->name('admin.bookings');
    Route::get('/meals', \App\Livewire\Admin\MealManager::class)->name('admin.meals');
    Route::get('/food-categories', \App\Livewire\Admin\FoodCategoryManager::class)->name('admin.food-categories');
    Route::get('/floor-types', \App\Livewire\Admin\FloorTypeManager::class)->name('admin.floor-types');

});


});

require __DIR__.'/auth.php';




