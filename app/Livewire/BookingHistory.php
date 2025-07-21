<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingHistory extends Component
{
    public function render()
    {
        $bookings = Booking::with(['room.roomType'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.booking-history', compact('bookings'));
    }
}
