
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Order Breakfast</h1>

        @if ($currentBookings->isEmpty())
            <p class="text-gray-700">You have no active bookings. Please book a room to order breakfast.</p>
        @else
            <form wire:submit.prevent="order" class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Room</label>
                    <select wire:model="room_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Select Room</option>
                        @foreach($currentBookings as $booking)
                            <option value="{{ $booking->room_id }}">Room {{ $booking->room->room_number }} ({{ $booking->room->roomType->name }})</option>
                        @endforeach
                    </select>
                    @error('room_id') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meal</label>
                    <select wire:model="meal_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Select Meal</option>
                        @foreach($meals as $meal)
                            <option value="{{ $meal->id }}">{{ $meal->name }} (${{ $meal->price }})</option>
                        @endforeach
                    </select>
                    @error('meal_id') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" wire:model="quantity" min="1" class="mt-1 block w-full rounded-md border-gray-300">
                    @error('quantity') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                    <input type="text" wire:model="total_amount" readonly class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Place Order</button>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                @foreach($meals as $meal)
                    <div class="bg-white border rounded-lg p-4 shadow-md">
                        @if ($meal->image)
                            <img src="{{ asset('storage/' . $meal->image) }}" alt="Meal Image" class="w-full h-48 object-cover rounded-lg mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <h2 class="text-xl font-semibold text-gray-900">{{ $meal->name }}</h2>
                        <p class="text-gray-700">Price: ${{ $meal->price }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if (session('message'))
            <div class="mt-4 text-green-600">{{ session('message') }}</div>
        @endif
    </div>

