
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Search Rooms</h1>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Room Type</label>
                    <select wire:model.live="roomTypeId" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">All</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Min Price</label>
                    <input type="number" wire:model.live="minPrice" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Max Price</label>
                    <input type="number" wire:model.live="maxPrice" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            @forelse($rooms as $room)
                <div class="bg-white border rounded-lg p-4 shadow-md">
                    @if ($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                    <h2 class="text-xl font-semibold text-gray-900">{{ $room->roomType->name }}</h2>
                    <p class="text-gray-700">Room Number: {{ $room->room_number }}</p>
                    <p class="text-gray-700">Price: ${{ $room->price }}/night</p>
                    <p class="text-gray-700">Service: {{ $room->roomType->service }}</p>
                    <p class="text-gray-700">Floor Type{{ $room->floorType->name }}</p>

                   @if (Auth::check() && (!Auth::user()->is_admin))
                    <a href="{{ route('booking.form', $room->id) }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Book Now</a>

                   @endif
                </div>
            @empty
                <p class="text-gray-700 col-span-3 text-center">No rooms available for the selected criteria.</p>
            @endforelse
        </div>
    </div>

