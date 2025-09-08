<?php

namespace App\Livewire\Home\Umkn;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.umkn")]
#[Title("Kelola Order")]
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
        $umknId = Auth::user()->umkn_id;

        if (!$umknId) {
            $this->orders = collect();
            return;
        }

        $query = Order::with([
                'user.profile',
                'items.product'
            ])
            ->whereHas('items.product', function ($q) use ($umknId) {
                $q->where('umkn_id', $umknId);
            });

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
        $umknId = Auth::user()->umkn_id;
        
        if (!$umknId) {
            $this->dispatch("alert", message: "Anda tidak memiliki akses UMKN.", type: "error");
            return;
        }

        $order = Order::with(['items.product'])
            ->whereHas('items.product', function ($q) use ($umknId) {
                $q->where('umkn_id', $umknId);
            })
            ->where('id', $orderId)
            ->first();

        if (!$order) {
            $this->dispatch("alert", message: "Order tidak ditemukan atau bukan milik UMKN Anda.", type: "error");
            return;
        }

        // Validasi transisi status yang dibolehkan
        $allowedTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['shipped', 'cancelled'],
            'shipped' => ['completed'],
            'completed' => [], // Tidak bisa diubah lagi
            'cancelled' => [] // Tidak bisa diubah lagi
        ];

        if (!in_array($newStatus, $allowedTransitions[$order->status])) {
            $this->dispatch("alert", message: "Transisi status tidak valid.", type: "error");
            return;
        }

        // Handle stock restoration jika dibatalkan
        if ($newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->stock += $item->qty;
                    $item->product->save();
                }
            }
        }

        $order->status = $newStatus;
        $order->save();

        $statusMessages = [
            'paid' => 'Order berhasil dikonfirmasi sebagai telah dibayar.',
            'shipped' => 'Order berhasil diubah menjadi dikirim.',
            'completed' => 'Order berhasil diselesaikan.',
            'cancelled' => 'Order berhasil dibatalkan dan stok telah dikembalikan.'
        ];

        $message = $statusMessages[$newStatus] ?? 'Status order berhasil diperbarui.';
        $this->dispatch("alert", message: $message, type: "success");
        $this->loadOrders();
    }

    public function render()
    {
        return view('livewire.home.umkn.order-page');
    }
}