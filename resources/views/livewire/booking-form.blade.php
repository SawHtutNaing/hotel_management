<div class="max-w-md mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Book Room: {{ $room->roomType->name }}</h1>
    <p>Room Number: {{ $room->room_number }}</p>
    <p>Price: ${{ $room->price }}/night</p>

    <form wire:submit.prevent="book" class="space-y-4 mt-4">
        <div>
            <label class="block text-sm font-medium">Check-In</label>
            <input type="date" wire:model="checkIn" class="mt-1 block w-full rounded-md border-gray-300">
            @error('checkIn') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Check-Out</label>
            <input type="date" wire:model="checkOut" class="mt-1 block w-full rounded-md border-gray-300">
            @error('checkOut') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Booking</button>
    </form>

    @if (session('message'))
        <div class="mt-4 text-green-600">{{ session('message') }}</div>
    @endif
    @if (session('error'))
        <div class="mt-4 text-red-600">{{ session('error') }}</div>
    @endif
</div>
