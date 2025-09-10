<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.admin")]
#[Title("Manajemen Order")]
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

        $query = Order::with([
                'user.profile',
                'items.product'
            ]);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $this->orders = $query->orderBy('created_at', 'desc')->get();
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

    public function updateOrderStatus($orderId, $newStatus)
    {
        $order = Order::with('items')->find($orderId);

        if (!$order) {
            $this->dispatch("alert", message: "Order tidak ditemukan.", type: "error");
            return;
        }

        $order->status = $newStatus;
        $order->save();

        $this->dispatch("alert", message: "Status order berhasil diubah menjadi '{$newStatus}'.", type: "success");

        $this->loadOrders();
    }


    public function render()
    {
        return view('livewire.admin.order-page');
    }
}
