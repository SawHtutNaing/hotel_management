<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage Bookings</h1>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3">User</th>
                <th class="px-6 py-3">Room</th>
                <th class="px-6 py-3">Check-In</th>
                <th class="px-6 py-3">Check-Out</th>
                <th class="px-6 py-3">Total Price</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td class="px-6 py-4">{{ $booking->user->name }}</td>
                    <td class="px-6 py-4">{{ $booking->room->roomType->name }} ({{ $booking->room->room_number }})</td>
                    <td class="px-6 py-4">{{ $booking->check_in }}</td>
                    <td class="px-6 py-4">{{ $booking->check_out }}</td>
                    <td class="px-6 py-4">${{ $booking->total_price }}</td>
                    <td class="px-6 py-4">{{ ucfirst($booking->status) }}</td>
                    <td class="px-6 py-4">
                        @if($booking->status == 'pending')
                            <button wire:click="accept({{ $booking->id }})" class="text-green-600">Accept</button>
                            <button wire:click="reject({{ $booking->id }})" class="text-red-600">Reject</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('message'))
        <div class="mt-4 text-green-600">{{ session('message') }}</div>
    @endif
</div>
