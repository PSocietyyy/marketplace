<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Umkn;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.admin")]
#[Title("Admin Dashboard")]
class Dashboard extends Component
{
    public $totalUmkns = 0;
    public $totalUsers = 0;
    public $totalProducts = 0;
    public $totalOrders = 0;
    public $totalRevenue = 0;
    public $pendingOrders = 0;
    public $lowStockProducts = 0;
    public $recentOrders = [];
    public $topProducts = [];
    public $topUmkns = [];
    public $monthlyStats = [];
    public $userStats = [];
    public $orderStatusStats = [];
    public $selectedUmkn = null;
    public $selectedStatus = null;

    // Filter options
    public $umknOptions = [];
    public $statusOptions = [
        '' => 'Semua Status',
        'pending' => 'Menunggu',
        'processing' => 'Diproses', 
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan'
    ];

    public function mount()
    {
        $this->umknOptions = Umkn::pluck('umkn_name', 'id')->prepend('Semua UMKN', '')->toArray();
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Total statistik dasar
        $this->totalUmkns = Umkn::count();
        $this->totalUsers = User::where('role', 'user')
                        ->whereNull('umkn_id')
                        ->count();
        $this->totalProducts = Product::when($this->selectedUmkn, fn($q) => $q->where('umkn_id', $this->selectedUmkn))->count();
        
        // Query orders dengan filter
        $ordersQuery = Order::query()
            ->when($this->selectedUmkn, function($q) {
                $q->whereHas('items.product', fn($subQ) => $subQ->where('umkn_id', $this->selectedUmkn));
            })
            ->when($this->selectedStatus, fn($q) => $q->where('status', $this->selectedStatus));

        $this->totalOrders = $ordersQuery->count();
        
        // Total revenue (hanya completed orders)
        $this->totalRevenue = (clone $ordersQuery)->where('status', 'completed')->sum('total_price');
        
        // Pending orders lama (lebih dari 3 hari)
        $this->pendingOrders = Order::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(3))
            ->when($this->selectedUmkn, function($q) {
                $q->whereHas('items.product', fn($subQ) => $subQ->where('umkn_id', $this->selectedUmkn));
            })
            ->count();

        // Produk dengan stok rendah (< 10)
        $this->lowStockProducts = Product::where('stock', '<', 10)
            ->when($this->selectedUmkn, fn($q) => $q->where('umkn_id', $this->selectedUmkn))
            ->count();

        // Pesanan terbaru
        $this->recentOrders = Order::with(['user', 'items.product.umkn'])
            ->when($this->selectedUmkn, function($q) {
                $q->whereHas('items.product', fn($subQ) => $subQ->where('umkn_id', $this->selectedUmkn));
            })
            ->when($this->selectedStatus, fn($q) => $q->where('status', $this->selectedStatus))
            ->latest()
            ->take(4)
            ->get();

        // Produk terlaris global
        $this->topProducts = Product::withSum('completed_order_items as total_qty', 'qty')
            ->with('umkn')
            ->when($this->selectedUmkn, fn($q) => $q->where('umkn_id', $this->selectedUmkn))
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        // Top UMKN berdasarkan revenue
        $this->topUmkns = Umkn::select('umkns.*')
        ->join('products', 'products.umkn_id', '=', 'umkns.id')
        ->join('order_items', 'order_items.product_id', '=', 'products.id')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('orders.status', 'completed')
        ->groupBy('umkns.id')
        ->selectRaw('SUM(order_items.qty * products.price) as total_revenue')
        ->selectRaw('COUNT(DISTINCT order_items.order_id) as total_orders')
        ->orderByDesc('total_revenue')
        ->take(10)
        ->get();

        // Statistik user berdasarkan role
        $this->userStats = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get()
            ->mapWithKeys(fn($item) => [$item->role => $item->count]);

        // Statistik order berdasarkan status
        $this->orderStatusStats = Order::selectRaw('status, COUNT(*) as count')
            ->when($this->selectedUmkn, function($q) {
                $q->whereHas('items.product', fn($subQ) => $subQ->where('umkn_id', $this->selectedUmkn));
            })
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [$item->status => $item->count]);

        // Statistik bulanan (12 bulan terakhir)
        $this->monthlyStats = collect(range(11, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            
            $ordersQuery = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
                
            if ($this->selectedUmkn) {
                $ordersQuery->whereHas('items.product', fn($q) => $q->where('umkn_id', $this->selectedUmkn));
            }
            
            $orders = $ordersQuery->count();
            $revenue = (clone $ordersQuery)->where('status', 'completed')->sum('total_price');
            
            return [
                'month' => $date->format('M Y'),
                'orders' => $orders,
                'revenue' => $revenue
            ];
        });
    }

    public function updatedSelectedUmkn()
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedStatus()
    {
        $this->loadDashboardData();
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800', 
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusText($status)
    {
        return match($status) {
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($status)
        };
    }

    public function getRoleText($role)
    {
        return match($role) {
            'admin' => 'Admin',
            'user' => 'Customer',
            'umkn' => 'UMKN User',
            default => ucfirst($role)
        };
    }

    public function refreshData()
    {
        $this->loadDashboardData();
        $this->dispatch("alert", message: "Data berhasil diperbarui", type: "info");
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}