<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage Rooms</h1>

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm font-medium">Room Type</label>
            <select wire:model="room_type_id" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="">Select Room Type</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('room_type_id') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Room Number</label>
            <input type="text" wire:model="room_number" class="mt-1 block w-full rounded-md border-gray-300">
            @error('room_number') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Price</label>
            <input type="number" wire:model="price" class="mt-1 block w-full rounded-md border-gray-300">
            @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ $isEditing ? 'Update' : 'Create' }} Room
        </button>
    </form>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3">Room Number</th>
                <th class="px-6 py-3">Room Type</th>
                <th class="px-6 py-3">Price</th>
                <th class="px-6 py-3">Availability</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                <tr>
                    <td class="px-6 py-4">{{ $room->room_number }}</td>
                    <td class="px-6 py-4">{{ $room->roomType->name }}</td>
                    <td class="px-6 py-4">${{ $room->price }}</td>
                    <td class="px-6 py-4">{{ $room->is_available ? 'Available' : 'Occupied' }}</td>
                    <td class="px-6 py-4">
                        <button wire:click="edit({{ $room->id }})" class="text-blue-600">Edit</button>
                        <button wire:click="delete({{ $room->id }})" class="text-red-600">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('message'))
        <div class="mt-4 text-green-600">{{ session('message') }}</div>
    @endif
</div>
