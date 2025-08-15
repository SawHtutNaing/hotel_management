<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\FloorType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RoomManager extends Component
{
    use WithFileUploads;

    public $rooms;
    public $room_types;
    public $floor_types;
    public $room_type_id;
    public $floor_type_id;
    public $room_number;
    public $is_available = true;
    public $price;
    public $image;
    public $editingRoomId = null;
    public $showCreateModal = false;
    public $showEditModal = false;

    protected $rules = [
        'room_type_id' => 'required|exists:room_types,id',
        'floor_type_id' => 'required|exists:floor_types,id',
        'room_number' => 'string|max:255',
        'is_available' => 'boolean',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function mount()
    {
        $this->loadRooms();
        $this->room_types = RoomType::all();
        $this->floor_types = FloorType::all();
    }

    public function loadRooms()
    {
        $this->rooms = Room::with('roomType', 'floorType')->get();
    }

    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->showCreateModal = true;
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->resetInputFields();
        $this->resetValidation();
    }

    public function createRoom()
    {
        $this->validate();

        try {
            $roomData = [
                'room_type_id' => $this->room_type_id,
                'floor_type_id' => $this->floor_type_id,
                'room_number' => $this->room_number,
                'is_available' => $this->is_available,
                'price' => $this->price,
            ];

            if ($this->image) {
                $roomData['image'] = $this->image->store('rooms', 'public');
            }

            Room::create($roomData);

            $this->loadRooms();
            $this->closeModal();
            $this->dispatch('notify', ['message' => 'Room created successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error creating room: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error creating room', 'type' => 'error']);
        }
    }

    public function editRoom($id)
    {
        $room = Room::findOrFail($id);
        $this->editingRoomId = $id;
        $this->room_type_id = $room->room_type_id;
        $this->floor_type_id = $room->floor_type_id;
        $this->room_number = $room->room_number;
        $this->is_available = $room->is_available;
        $this->price = $room->price;
        $this->image = null;
        $this->showEditModal = true;

        // Update unique rule for editing
        $this->rules['room_number'] = 'required|string|max:255|unique:rooms,room_number,' . $id;
    }

    public function updateRoom()
    {
        $this->validate();

        try {
            $room = Room::findOrFail($this->editingRoomId);
            $roomData = [
                'room_type_id' => $this->room_type_id,
                'floor_type_id' => $this->floor_type_id,
                'room_number' => $this->room_number,
                'is_available' => $this->is_available,
                'price' => $this->price,
            ];

            if ($this->image) {
                // Delete old image if exists
                if ($room->image) {
                    Storage::disk('public')->delete($room->image);
                }
                $roomData['image'] = $this->image->store('rooms', 'public');
            }

            $room->update($roomData);

            $this->loadRooms();
            $this->closeModal();
            $this->dispatch('notify', ['message' => 'Room updated successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error updating room: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error updating room', 'type' => 'error']);
        }
    }

    public function deleteRoom($id)
    {
        try {
            $room = Room::findOrFail($id);
            if ($room->bookings()->count() > 0) {
                $this->dispatch('notify', ['message' => 'Cannot delete room with active bookings', 'type' => 'error']);
                return;
            }
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $room->delete();

            $this->loadRooms();
            $this->dispatch('notify', ['message' => 'Room deleted successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error deleting room: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error deleting room', 'type' => 'error']);
        }
    }

    private function resetInputFields()
    {
        $this->room_type_id = '';
        $this->floor_type_id = '';
        $this->room_number = '';
        $this->is_available = true;
        $this->price = '';
        $this->image = null;
        $this->editingRoomId = null;
        $this->rules['room_number'] = 'required|string|max:255|unique:rooms,room_number';
    }

    public function render()
    {
        return view('livewire.admin.room-manager');
    }
}
