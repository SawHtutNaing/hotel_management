
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Manage Rooms</h1>

        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}" class="space-y-4 mb-6" enctype="multipart/form-data">
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Type</label>
                <select wire:model="room_type_id" class="mt-1 block w-full rounded-md border-gray-300">
                    <option value="">Select Room Type</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('room_type_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" wire:model="room_number" class="mt-1 block w-full rounded-md border-gray-300">
                @error('room_number') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" wire:model="price" class="mt-1 block w-full rounded-md border-gray-300">
                @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" wire:model="image" class="mt-1 block w-full">
                @error('image') <span class="text-red-600">{{ $message }}</span> @enderror
                @if ($isEditing && $roomId)
                    @php
                        $room = \App\Models\Room::find($roomId);
                    @endphp
                    @if ($room && $room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" class="mt-2 h-32 w-auto rounded">
                    @endif
                @endif
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                {{ $isEditing ? 'Update' : 'Create' }} Room
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Room Number</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Room Type</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Availability</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td class="px-6 py-4">
                                @if ($room->image)
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" class="h-16 w-auto rounded">
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $room->room_number }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $room->roomType->name }}</td>
                            <td class="px-6 py-4 text-gray-900">${{ $room->price }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $room->is_available ? 'Available' : 'Occupied' }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="edit({{ $room->id }})" class="text-blue-600 hover:text-blue-800">Edit</button>
                                <button wire:click="delete({{ $room->id }})" class="text-red-600 hover:text-red-800 ml-2">Delete</button>
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

