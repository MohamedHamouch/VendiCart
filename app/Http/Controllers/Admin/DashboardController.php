<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for the dashboard
        $stats = [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
        ];

        // Get recent orders
        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get low stock products
        $low_stock_products = Product::where('stock_quantity', '<', 10)
            ->get();

        // Get top selling products
        $top_selling_products = DB::table('order_items')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'low_stock_products',
            'top_selling_products'
        ));
    }
}