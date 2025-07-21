
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Your Booking History</h1>

        @if ($bookings->isEmpty())
            <p class="text-gray-700">You have no bookings yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Room</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Room Number</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Check-In</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Check-Out</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total Price</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            {{-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Booked On Notable</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 text-gray-900">{{ $booking->room->roomType->name }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $booking->room->room_number }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $booking->check_in }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $booking->check_out }}</td>
                                <td class="px-6 py-4 text-gray-900">${{ $booking->total_price }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ ucfirst($booking->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

