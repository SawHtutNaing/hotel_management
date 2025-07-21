<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\RoomType;

class RoomSearch extends Component
{
    public $checkIn;
    public $checkOut;
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $roomTypeId;

    public function render()
    {

        $rooms = Room::where('is_available', true)
            ->whereBetween('price', [$this->minPrice, $this->maxPrice])
            ->when($this->roomTypeId, function ($query) {
                $query->where('room_type_id', $this->roomTypeId);
            })
            ->when($this->checkIn && $this->checkOut, function ($query) {
                $query->whereDoesntHave('bookings', function ($q) {
                    $q->whereBetween('check_in', [$this->checkIn, $this->checkOut])
                        ->orWhereBetween('check_out', [$this->checkIn, $this->checkOut]);
                });
            })
            ->with('roomType')
            ->get();

        $roomTypes = RoomType::all();

        return view('livewire.room-search', compact('rooms', 'roomTypes'));
    }
}
