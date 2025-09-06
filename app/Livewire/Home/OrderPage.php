<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

#[Layout("layouts.home")]
#[Title("Pesanan")]
class OrderPage extends Component
{
    public $statusFilter = 'all';
    public $orders = [];
    public $showDetailId = null;

    protected $listeners = ['refreshOrders' => 'loadOrders'];

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $query = Order::where('user_id', Auth::id());

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->orders = $query->with('items.product')->orderBy('created_at', 'desc')->get();
    }

    public function updatedStatusFilter()
    {
        $this->loadOrders();
    }

    public function toggleDetail($orderId)
    {
        if ($this->showDetailId === $orderId) {
            $this->showDetailId = null;
        } else {
            $this->showDetailId = $orderId;
        }
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $orderId)->first();

        if (!$order) {
            session()->flash('message', 'Order tidak ditemukan.');
            return;
        }

        if (in_array($order->status, ['pending', 'paid'])) {
            $order->status = 'cancelled';
            $order->save();

            session()->flash('message', 'Order berhasil dibatalkan.');
            $this->loadOrders();
        } else {
            session()->flash('message', 'Order tidak bisa dibatalkan pada status ini.');
        }
    }

    public function render()
    {
        return view('livewire.home.order-page');
    }
}
