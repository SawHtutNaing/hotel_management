<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Room;
use App\Models\RoomType;

class RoomManager extends Component
{
    public $room_type_id, $room_number, $price;
    public $roomId;
    public $isEditing = false;

    protected $rules = [
        'room_type_id' => 'required|exists:room_types,id',
        'room_number' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ];

    public function create()
    {
        $this->validate();
        Room::create([
            'room_type_id' => $this->room_type_id,
            'room_number' => $this->room_number,
            'price' => $this->price,
            'is_available' => true,
        ]);
        $this->resetForm();
        session()->flash('message', 'Room created successfully!');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $this->roomId = $id;
        $this->room_type_id = $room->room_type_id;
        $this->room_number = $room->room_number;
        $this->price = $room->price;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        $room = Room::findOrFail($this->roomId);
        $room->update([
            'room_type_id' => $this->room_type_id,
            'room_number' => $this->room_number,
            'price' => $this->price,
        ]);
        $this->resetForm();
        session()->flash('message', 'Room updated successfully!');
    }

    public function delete($id)
    {
        Room::findOrFail($id)->delete();
        session()->flash('message', 'Room deleted successfully!');
    }

    public function resetForm()
    {
        $this->room_type_id = '';
        $this->room_number = '';
        $this->price = '';
        $this->isEditing = false;
        $this->roomId = null;
    }

    public function render()
    {
        $rooms = Room::with('roomType')->get();
        $roomTypes = RoomType::all();
        return view('livewire.admin.room-manager', compact('rooms', 'roomTypes'));
    }
}
