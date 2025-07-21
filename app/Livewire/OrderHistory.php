<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistory extends Component
{
    public function render()
    {
        $user = Auth::user();
        $orders = $user->is_admin
            ? Order::with(['room', 'room.roomType', 'meal'])->orderBy('created_at', 'desc')->get()
            : Order::where('user_id', $user->id)
                ->with(['room', 'room.roomType', 'meal'])
                ->orderBy('created_at', 'desc')
                ->get();

        return view('livewire.order-history', compact('orders'));
    }
}
