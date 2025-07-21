<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage Room Types</h1>

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300">
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea wire:model="description" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium">Base Price</label>
            <input type="number" wire:model="base_price" class="mt-1 block w-full rounded-md border-gray-300">
            @error('base_price') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ $isEditing ? 'Update' : 'Create' }} Room Type
        </button>
    </form>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Base Price</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roomTypes as $roomType)
                <tr>
                    <td class="px-6 py-4">{{ $roomType->name }}</td>
                    <td class="px-6 py-4">${{ $roomType->base_price }}</td>
                    <td class="px-6 py-4">
                        <button wire:click="edit({{ $roomType->id }})" class="text-blue-600">Edit</button>
                        <button wire:click="delete({{ $roomType->id }})" class="text-red-600">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('message'))
        <div class="mt-4 text-green-600">{{ session('message') }}</div>
    @endif
</div>
