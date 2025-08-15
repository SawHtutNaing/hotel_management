<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FoodOrder extends Component
{
    public $room_id, $meal_id, $quantity = 1;
    public $total_amount = 0;
public $food_category_id; // new property for selected category

    protected $rules = [
        'room_id' => 'required|exists:rooms,id',
        'meal_id' => 'required|exists:meals,id',
        'quantity' => 'required|integer|min:1',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'meal_id' || $propertyName === 'quantity') {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        if ($this->meal_id && $this->quantity) {
            $meal = Meal::find($this->meal_id);
            if ($meal) {
                $this->total_amount = $meal->price * $this->quantity;
            }
        }
    }

    public function order()
    {
        $this->validate();

        Order::create([
            'user_id' => Auth::id(),
            'room_id' => $this->room_id,
            'meal_id' => $this->meal_id,
            'quantity' => $this->quantity,
            'total_amount' => $this->total_amount,
            'status' => 'confirmed',
        ]);

        $this->reset(['room_id', 'meal_id', 'quantity', 'total_amount']);
        session()->flash('message', 'Food ordered successfully!');
    }

  public function render()
{
    $categories = \App\Models\FoodCategory::all();

    $mealsQuery = Meal::query();
    if ($this->food_category_id) {
        $mealsQuery->where('food_category_id', $this->food_category_id);
    }
    $meals = $mealsQuery->get();

    $currentBookings = Booking::where('user_id', Auth::id())
        ->where('status', 'confirmed')
        ->where('check_in', '<=', Carbon::today())
        ->where('check_out', '>=', Carbon::today())
        ->with('room')
        ->get();

    return view('livewire.food-order', compact('meals', 'currentBookings', 'categories'));
}

}
