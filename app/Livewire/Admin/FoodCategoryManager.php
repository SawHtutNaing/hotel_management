<?php

namespace App\Livewire\Admin;

use App\Models\FoodCategory;
use Livewire\Component;
use Livewire\WithPagination;

class FoodCategoryManager extends Component
{
    use WithPagination;

    public $name, $description, $food_category_id;
    public $isModalOpen = false;

    public function render()
    {
        return view('livewire.admin.food-category-manager', [
            'foodCategories' => FoodCategory::paginate(10),
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
        $this->food_category_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        FoodCategory::updateOrCreate(['id' => $this->food_category_id], [
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', $this->food_category_id ? 'Food Category updated successfully.' : 'Food Category created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $foodCategory = FoodCategory::findOrFail($id);
        $this->food_category_id = $id;
        $this->name = $foodCategory->name;
        $this->description = $foodCategory->description;
        $this->openModal();
    }

    public function delete($id)
    {
        FoodCategory::find($id)->delete();
        session()->flash('message', 'Food Category deleted successfully.');
    }
}
