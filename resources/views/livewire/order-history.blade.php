
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Order History</h1>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if ($orders->isEmpty())
            <p class="text-gray-700 text-center">No orders found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Order ID</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Meal</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Quantity</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total Price</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $no =>  $order)
                            <tr>
                                <td class="px-6 py-4 text-gray-900">{{ $no + 1 }}</td>
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
                                <td class="px-6 py-4 text-gray-900">
                                    @if(auth()->user()->is_admin)
                                        <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)" class="border-gray-300 rounded-md w-[160px]">
                                            <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                            <option value="confirmed" @if($order->status == 'confirmed') selected @endif>Confirmed</option>
                                            <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                                        </select>
                                    @else
                                        {{ ucfirst($order->status) }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-900">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
