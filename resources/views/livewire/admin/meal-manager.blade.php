
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Manage Meals</h1>

        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}" class="space-y-4 mb-6" enctype="multipart/form-data">
            <div>
                <label class="block text-sm font-medium text-gray-700">Meal Name</label>
                <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300">
                @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" wire:model="price" step="0.01" class="mt-1 block w-full rounded-md border-gray-300">
                @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" wire:model="image" class="mt-1 block w-full">
                @error('image') <span class="text-red-600">{{ $message }}</span> @enderror
                @if ($isEditing && $mealId)
                    @php
                        $meal = \App\Models\Meal::find($mealId);
                    @endphp
                    @if ($meal && $meal->image)
                        <img src="{{ asset('storage/' . $meal->image) }}" alt="Meal Image" class="mt-2 h-32 w-auto rounded">
                    @endif
                @endif
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                {{ $isEditing ? 'Update' : 'Create' }} Meal
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meals as $meal)
                        <tr>
                            <td class="px-6 py-4">
                                @if ($meal->image)
                                    <img src="{{ asset('storage/' . $meal->image) }}" alt="Meal Image" class="h-16 w-auto rounded">
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $meal->name }}</td>
                            <td class="px-6 py-4 text-gray-900">${{ $meal->price }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="edit({{ $meal->id }})" class="text-blue-600 hover:text-blue-800">Edit</button>
                                <button wire:click="delete({{ $meal->id }})" class="text-red-600 hover:text-red-800 ml-2">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (session('message'))
            <div class="mt-4 text-green-600">{{ session('message') }}</div>
        @endif
    </div>

