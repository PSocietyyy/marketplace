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
        $order = Order::where('user_id', Auth::id())->where('id', $orderId)->with('items.product')->first();

        if (!$order) {
            session()->flash('message', 'Order tidak ditemukan.');
            $this->dispatch("alert", message: "Order tidak ditemukan", type: "warning");
            return;
        }

        if (in_array($order->status, ['pending', 'paid'])) {
            // Tambah stok produk sesuai qty di order items
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->stock += $item->qty;
                    $item->product->save();
                }
            }

            $order->status = 'cancelled';
            $order->save();

            $this->dispatch("alert", message: "Order berhasil dibatalkan dan stok produk telah diperbarui.", type: "success");
            $this->loadOrders();
        } else {
            $this->dispatch("alert", message: "Order tidak bisa dibatalkan pada status ini.", type: "error");
        }
    }

    public function updateOrderStatusCompleted($orderId)
    {
        $order = Order::where('user_id', Auth::id())->where('id', $orderId)->with('items.product')->first();

        if (!$order) {
            session()->flash('message', 'Order tidak ditemukan.');
            $this->dispatch("alert", message: "Order tidak ditemukan", type: "warning");
            return;
        }

        // Tambah stok produk sesuai qty di order items
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->stock += $item->qty;
                $item->product->save();
            }
        }

        $order->status = 'completed';
        $order->save();

        $this->dispatch("alert", message: "Order telah diterima.", type: "success");
        $this->loadOrders();
    }

    public function productDetail($id)
    {
        if($id)
        {
            return redirect()->route('home.product.detail', $id);
        }
        $this->dispatch("alert", "Product tidak ditemukan", "warning");
    }


    public function render()
    {
        return view('livewire.home.order-page');
    }
}
