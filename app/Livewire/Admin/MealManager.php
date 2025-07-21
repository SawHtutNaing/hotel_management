<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Meal;
use Illuminate\Support\Facades\Storage;

class MealManager extends Component
{
    use WithFileUploads;

    public $name, $price, $image;
    public $mealId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
    ];

    public function create()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('meals', 'public') : null;

        Meal::create([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        session()->flash('message', 'Meal created successfully!');
    }

    public function edit($id)
    {
        $meal = Meal::findOrFail($id);
        $this->mealId = $id;
        $this->name = $meal->name;
        $this->price = $meal->price;
        $this->image = null;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $meal = Meal::findOrFail($this->mealId);
        $imagePath = $meal->image;

        if ($this->image) {
            if ($meal->image) {
                Storage::disk('public')->delete($meal->image);
            }
            $imagePath = $this->image->store('meals', 'public');
        }

        $meal->update([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        session()->flash('message', 'Meal updated successfully!');
    }

    public function delete($id)
    {
        $meal = Meal::findOrFail($id);
        if ($meal->image) {
            Storage::disk('public')->delete($meal->image);
        }
        $meal->delete();
        session()->flash('message', 'Meal deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->price = '';
        $this->image = null;
        $this->isEditing = false;
        $this->mealId = null;
    }

    public function render()
    {
        $meals = Meal::all();
        return view('livewire.admin.meal-manager', compact('meals'));
    }
}
