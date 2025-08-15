<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Meal;
use App\Models\FoodCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MealManager extends Component
{
    use WithFileUploads;

    public $meals;
    public $name;
    public $price;
    public $image;
    public $food_category_id;
    public $editingMealId = null;
    public $showCreateModal = false;
    public $showEditModal = false;
    public $foodCategories;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048', // Max 2MB
        'food_category_id' => 'required|exists:food_categories,id',
    ];

    public function mount()
    {
        $this->loadMeals();
        $this->foodCategories = FoodCategory::all();
    }

    public function loadMeals()
    {
        $this->meals = Meal::with('foodCategory')->get();
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

    public function createMeal()
    {
        $this->validate();

        try {
            $mealData = [
                'name' => $this->name,
                'price' => $this->price,
                'food_category_id' => $this->food_category_id,
            ];

            if ($this->image) {
                $mealData['image'] = $this->image->store('meals', 'public');
            }

            Meal::create($mealData);

            $this->loadMeals();
            $this->closeModal();
            $this->dispatch('notify', ['message' => 'Meal created successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error creating meal: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error creating meal', 'type' => 'error']);
        }
    }

    public function editMeal($id)
    {
        $meal = Meal::findOrFail($id);
        $this->editingMealId = $id;
        $this->name = $meal->name;
        $this->price = $meal->price;
        $this->food_category_id = $meal->food_category_id;
        $this->image = null;
        $this->showEditModal = true;
    }

    public function updateMeal()
    {
        $this->validate();

        try {
            $meal = Meal::findOrFail($this->editingMealId);
            $mealData = [
                'name' => $this->name,
                'price' => $this->price,
                'food_category_id' => $this->food_category_id,
            ];

            if ($this->image) {
                // Delete old image if exists
                if ($meal->image) {
                    Storage::disk('public')->delete($meal->image);
                }
                $mealData['image'] = $this->image->store('meals', 'public');
            }

            $meal->update($mealData);

            $this->loadMeals();
            $this->closeModal();
            $this->dispatch('notify', ['message' => 'Meal updated successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error updating meal: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error updating meal', 'type' => 'error']);
        }
    }

    public function deleteMeal($id)
    {
        try {
            $meal = Meal::findOrFail($id);
            if ($meal->image) {
                Storage::disk('public')->delete($meal->image);
            }
            $meal->delete();

            $this->loadMeals();
            $this->dispatch('notify', ['message' => 'Meal deleted successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error deleting meal: ' . $e->getMessage());
            $this->dispatch('notify', ['message' => 'Error deleting meal', 'type' => 'error']);
        }
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->price = '';
        $this->image = null;
        $this->food_category_id = null;
        $this->editingMealId = null;
    }

    public function render()
    {
        return view('livewire.admin.meal-manager');
    }
}
