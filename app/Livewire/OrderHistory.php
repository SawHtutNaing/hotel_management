<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        if (auth()->user()->is_admin) {
            $order->status = $status;
            $order->save();
            session()->flash('message', 'Order status updated successfully.');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $query = Order::with(['meal'])->orderBy('created_at', 'desc');

        if ($user->is_admin) {
            $orders = $query->paginate(10);
        } else {
            $orders = $query->where('user_id', $user->id)->paginate(10);
        }

        return view('livewire.order-history', compact('orders'));
    }
}
