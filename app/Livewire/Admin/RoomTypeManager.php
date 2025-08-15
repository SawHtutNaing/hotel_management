<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\RoomType;
use Illuminate\Support\Facades\Log;

class RoomTypeManager extends Component
{
    public $room_types;
    public $name;
    public $description;
    public $base_price;
    public $service;
    public $editingRoomTypeId = null;
    public $showCreateModal = false;
    public $showEditModal = false;

    protected $rules = [
        'name' => 'string|max:255',
        'description' => 'nullable|string',
        'base_price' => 'required|numeric|min:0',
        'service' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadRoomTypes();
    }

    public function loadRoomTypes()
    {
        $this->room_types = RoomType::all();
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

    public function createRoomType()
    {
        $this->validate();

        try {
            RoomType::create([
                'name' => $this->name,
                'description' => $this->description,
                'base_price' => $this->base_price,
                'service' => $this->service,
            ]);

            $this->loadRoomTypes();
            $this->closeModal();
            $this->dispatch('notify', ['message' => 'Room Type created successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error creating room type: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error creating room type', 'type' => 'error']);
        }
    }

    public function editRoomType($id)
    {
        $roomType = RoomType::findOrFail($id);
        $this->editingRoomTypeId = $id;
        $this->name = $roomType->name;
        $this->description = $roomType->description;
        $this->base_price = $roomType->base_price;
        $this->service = $roomType->service;
        $this->showEditModal = true;

        // Update unique rule for editing
        $this->rules['name'] = 'required|string|max:255|unique:room_types,name,' . $id;
    }

    public function updateRoomType()
    {
        $this->validate();

        try {
            $roomType = RoomType::findOrFail($this->editingRoomTypeId);
            $roomType->update([
                'name' => $this->name,
                'description' => $this->description,
                'base_price' => $this->base_price,
                'service' => $this->service,
            ]);

            $this->loadRoomTypes();
            $this->closeModal();
            $this->dispatch('notify', ['message' => 'Room Type updated successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error updating room type: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error updating room type', 'type' => 'error']);
        }
    }

    public function deleteRoomType($id)
    {
        try {
            $roomType = RoomType::findOrFail($id);
            if ($roomType->rooms()->count() > 0) {
                $this->dispatch('notify', ['message' => 'Cannot delete room type with associated rooms', 'type' => 'error']);
                return;
            }
            $roomType->delete();

            $this->loadRoomTypes();
            $this->dispatch('notify', ['message' => 'Room Type deleted successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error deleting room type: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error deleting room type', 'type' => 'error']);
        }
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->base_price = '';
        $this->service = '';
        $this->editingRoomTypeId = null;
        $this->rules['name'] = 'required|string|max:255|unique:room_types,name';
    }

    public function render()
    {
        return view('livewire.admin.room-type-manager');
    }
}
