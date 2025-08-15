<div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Meal Management</h1>
        <button wire:click="openCreateModal"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Meal
        </button>
    </div>

    <!-- Meals Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($meals as $meal)
                    <tr>
                        <!-- Image -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($meal->image)
                                <img src="{{ Storage::url($meal->image) }}"
                                     alt="{{ $meal->name }}"
                                     class="h-16 w-16 object-cover rounded">
                            @else
                                <span class="text-gray-500">No image</span>
                            @endif
                        </td>

                        <!-- Name -->
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meal->name }}</td>

                        <!-- Category -->
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meal->foodCategory->name ?? 'N/A' }}</td>

                        <!-- Price -->
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($meal->price, 2) }}</td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="editMeal({{ $meal->id }})"
                                    class="text-blue-600 hover:text-blue-900 mr-4">
                                Edit
                            </button>
                            <button wire:click="deleteMeal({{ $meal->id }})"
                                    onclick="return confirm('Are you sure you want to delete this meal?')"
                                    class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No meals found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Meal Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <h2 class="text-lg font-bold mb-4">Create New Meal</h2>
                <form wire:submit.prevent="createMeal">
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" wire:model="price" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Food Category</label>
                        <select wire:model="food_category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Category</option>
                            @foreach($foodCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('food_category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" wire:model="image" class="mt-1 block w-full">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="closeModal"
                                class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit Meal Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <h2 class="text-lg font-bold mb-4">Edit Meal</h2>
                <form wire:submit.prevent="updateMeal">
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" wire:model="price" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Food Category</label>
                        <select wire:model="food_category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Category</option>
                            @foreach($foodCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('food_category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" wire:model="image" class="mt-1 block w-full">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="button" wire:click="closeModal"
                                class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('notify', (event) => {
        alert(event.message);
    });
});
</script>
@endpush
