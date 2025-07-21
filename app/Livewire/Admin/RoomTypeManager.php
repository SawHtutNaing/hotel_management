<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\RoomType;

class RoomTypeManager extends Component
{
    public $name, $description, $base_price;
    public $roomTypeId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'base_price' => 'required|numeric|min:0',
    ];

    public function create()
    {
        $this->validate();
        RoomType::create([
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
        ]);
        $this->resetForm();
        session()->flash('message', 'Room Type created successfully!');
    }

    public function edit($id)
    {
        $roomType = RoomType::findOrFail($id);
        $this->roomTypeId = $id;
        $this->name = $roomType->name;
        $this->description = $roomType->description;
        $this->base_price = $roomType->base_price;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        $roomType = RoomType::findOrFail($this->roomTypeId);
        $roomType->update([
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
        ]);
        $this->resetForm();
        session()->flash('message', 'Room Type updated successfully!');
    }

    public function delete($id)
    {
        RoomType::findOrFail($id)->delete();
        session()->flash('message', 'Room Type deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->base_price = '';
        $this->isEditing = false;
        $this->roomTypeId = null;
    }

    public function render()
    {
        $roomTypes = RoomType::all();
        return view('livewire.admin.room-type-manager', compact('roomTypes'));
    }
}
