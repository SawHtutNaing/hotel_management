<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingForm extends Component
{
    public $roomId;
    public $checkIn;
    public $checkOut;

    protected $rules = [
        'checkIn' => 'required|date|after:today',
        'checkOut' => 'required|date|after:checkIn',
    ];

    public function mount($roomId)
    {
        $this->roomId = $roomId;
    }

    public function book()
    {
        $this->validate();

        $room = Room::findOrFail($this->roomId);
        if (!$room->is_available) {
            session()->flash('error', 'Room is not available.');
            return;
        }

        $days = \Carbon\Carbon::parse($this->checkIn)->diffInDays($this->checkOut);
        $totalPrice = $room->price * $days;

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $this->roomId,
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $room->is_available = false;
        $room->save();

        session()->flash('message', 'Booking request submitted successfully!');
        return redirect()->route('home');
    }

    public function render()
    {
        $room = Room::with('roomType')->findOrFail($this->roomId);
        return view('livewire.booking-form', compact('room'));
    }
}
