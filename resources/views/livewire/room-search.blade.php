<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Search Rooms</h1>
    <form class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- <div>
                <label class="block text-sm font-medium">Check-In</label>
                <input type="date" wire:model.live="checkIn" class="mt-1 block w-full rounded-md border-gray-300">
            </div> --}}
            {{-- <div>
                <label class="block text-sm font-medium">Check-Out</label>
                <input type="date" wire:model.live="checkOut" class="mt-1 block w-full rounded-md border-gray-300">
            </div> --}}
            <div>
                <label class="block text-sm font-medium">Room Type</label>
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
                <label class="block text-sm font-medium">Min Price</label>
                <input type="number" wire:model.live="minPrice" class="mt-1 block w-full rounded-md border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium">Max Price</label>
                <input type="number" wire:model.live="maxPrice" class="mt-1 block w-full rounded-md border-gray-300">
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        @foreach($rooms as $room)
            <div class="border rounded-lg p-4 shadow-sm">
                <h2 class="text-xl font-semibold">{{ $room->roomType->name }}</h2>
                <p>Room Number: {{ $room->room_number }}</p>
                <p>Price: ${{ $room->price }}/night</p>
                <a href="{{ route('booking.form', $room->id) }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Book Now</a>
            </div>
        @endforeach
    </div>
</div>
