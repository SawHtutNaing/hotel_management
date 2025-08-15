<?php

namespace App\Livewire\Admin;

use App\Models\FloorType;
use Livewire\Component;
use Livewire\WithPagination;

class FloorTypeManager extends Component
{
    use WithPagination;

    public $name, $description, $floor_type_id;
    public $isModalOpen = false;

    public function render()
    {
        return view('livewire.admin.floor-type-manager', [
            'floorTypes' => FloorType::paginate(10),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->floor_type_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        FloorType::updateOrCreate(['id' => $this->floor_type_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', $this->floor_type_id ? 'Floor Type updated successfully.' : 'Floor Type created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $floorType = FloorType::findOrFail($id);
        $this->floor_type_id = $id;
        $this->name = $floorType->name;
        $this->description = $floorType->description;
        $this->openModal();
    }

    public function delete($id)
    {
        FloorType::find($id)->delete();
        session()->flash('message', 'Floor Type deleted successfully.');
    }
}
