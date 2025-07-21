<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Room;

class BookingManager extends Component
{
    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);
        $booking->room->update(['is_available' => false]);
        session()->flash('message', 'Booking confirmed successfully!');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'rejected']);
        session()->flash('message', 'Booking rejected successfully!');
    }

    public function render()
    {
        $bookings = Booking::with(['user', 'room.roomType'])->get();
        return view('livewire.admin.booking-manager', compact('bookings'));
    }
}
