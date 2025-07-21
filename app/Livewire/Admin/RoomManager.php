<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Storage;

class RoomManager extends Component
{
    use WithFileUploads;

    public $room_type_id, $room_number, $price, $image;
    public $roomId;
    public $isEditing = false;

    protected $rules = [
        'room_type_id' => 'required|exists:room_types,id',
        'room_number' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function create()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('rooms', 'public') : null;

        Room::create([
            'room_type_id' => $this->room_type_id,
            'room_number' => $this->room_number,
            'price' => $this->price,
            'is_available' => true,
            'image' => $imagePath,
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
        $this->image = null; // Reset image input
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $room = Room::findOrFail($this->roomId);
        $imagePath = $room->image;

        if ($this->image) {
            // Delete old image if exists
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $imagePath = $this->image->store('rooms', 'public');
        }

        $room->update([
            'room_type_id' => $this->room_type_id,
            'room_number' => $this->room_number,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        session()->flash('message', 'Room updated successfully!');
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();
        session()->flash('message', 'Room deleted successfully!');
    }

    public function resetForm()
    {
        $this->room_type_id = '';
        $this->room_number = '';
        $this->price = '';
        $this->image = null;
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
