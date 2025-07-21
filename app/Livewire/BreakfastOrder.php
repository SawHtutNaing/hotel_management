<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BreakfastOrder extends Component
{
    public $room_id, $meal_id, $quantity = 1;
    public $total_amount = 0;

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
        session()->flash('message', 'Breakfast ordered successfully!');
    }

    public function render()
    {
        $meals = Meal::all();
        $currentBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'confirmed')
            ->where('check_in', '<=', Carbon::today())
            ->where('check_out', '>=', Carbon::today())
            ->with('room')
            ->get();

            // dd($currentBookings);
        return view('livewire.breakfast-order', compact('meals', 'currentBookings'));
    }
}
