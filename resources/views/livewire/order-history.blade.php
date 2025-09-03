
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Order History</h1>

        @if ($orders->isEmpty())
            <p class="text-gray-700 text-center">No orders found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Order ID</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Room</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Meal</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Quantity</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total Amount</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $no =>  $order)
                            <tr>
                                <td class="px-6 py-4 text-gray-900">{{ $no + 1 }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $order->room->room_number }} ({{ $order->room->roomType->name }})</td>
                                <td class="px-6 py-4 text-gray-900">{{ $order->meal->name }}</td>
                                <td class="px-6 py-4">
                                    @if ($order->meal->image)
                                        <img src="{{ asset('storage/' . $order->meal->image) }}" alt="Meal Image" class="h-16 w-auto rounded">
                                    @else
                                        <span class="text-gray-500">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-900">{{ $order->quantity }}</td>
                                <td class="px-6 py-4 text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ ucfirst($order->status) }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
