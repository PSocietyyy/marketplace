<?php

namespace App\Livewire\Home\Umkn;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.umkn")]
#[Title("Dashboard")]
class Dashboard extends Component
{
    public $totalProducts = 0;
    public $totalOrders = 0;
    public $totalRevenue = 0;
    public $lowStockProducts = 0;
    public $recentOrders = [];
    public $topProducts = [];
    public $monthlyStats = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Total produk
        $this->totalProducts = Product::where("umkn_id", Auth::user()->umkn_id)->count();

        // Total pesanan
        $this->totalOrders = Order::whereNotIn('status', ['completed', 'cancelled'])
            ->whereHas('items.product', function ($q) {
                $q->where('umkn_id', Auth::user()->umkn_id);
            })
            ->count();

        // Total revenue
        $this->totalRevenue = DB::table('orders')
            ->where('status', 'completed')
            ->sum('total_price');

        // Produk dengan stok rendah (< 10)
        $this->lowStockProducts = Product::where('stock', '<', 10)->count();

        // Pesanan terbaru (5 terakhir)
        $this->recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Produk terlaris (berdasarkan quantity terjual)        
        $this->topProducts = Product::withSum('completed_order_items as total_qty', 'qty')
        ->where("umkn_id", Auth::user()->umkn_id)
        ->orderByDesc('total_qty')
        ->take(5)
        ->get();
        // dd($this->topProducts);

        // Statistik bulanan (6 bulan terakhir)
        $this->monthlyStats = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'month' => $date->format('M'),
                'orders' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'revenue' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->where('status', 'completed')
                    ->sum('total_price')
            ];
        });

        
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

    public function refreshData()
    {
        $this->loadDashboardData();
        $this->dispatch("alert", message: "Data berhasil di perbarui", type: "info");
    }

    public function render()
    {
        return view('livewire.home.umkn.dashboard');
    }
}