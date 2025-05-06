<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon; // 👈 Make sure to import Carbon

class AdminController extends Controller
{
    public function index()
    {
        $c_users = ['total' => User::count()];
        $c_categorie = ['total' => Category::count()];
        $c_product = ['total' => Product::count()];
        $c_sale = ['total' => Sale::count()];
        
        $lowStockProducts = Product::where('quantity', '>', 0)
        ->where('quantity', '<=', 5)
        ->get();


        // Calculate nearly expired products (within next 30 days)
        $nearlyExpiredCount = Product::whereDate('expiry_date', '>=', now())
            ->whereDate('expiry_date', '<=', Carbon::now()->addDays(7))
            ->count();
            $expiredCount = Product::whereDate('expiry_date', '<', Carbon::today())->count();
            $products_sold = Product::with('sales')
            ->get()
            ->map(function ($product) {
                $product->totalSold = $product->sales->sum(function ($sale) {
                    return $sale->price * $sale->quantity;
                });
                $product->totalQty = $product->sales->sum('quantity');
                return $product;
            })
            ->filter(function ($product) {
                return $product->totalQty >= 5; // Only include products with sales
            })
            ->sortByDesc('totalQty') // Sort by total quantity sold
            ->take(10) // Get the top 10 highest-selling products
            ->values();
        
        $recent_sales = Sale::with('product')->latest()->take(10)->get(); // Keep recent sales intact        
        $recent_products = Product::with('category', 'media')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'c_users',
            'c_categorie',
            'c_product',
            'c_sale',
            'lowStockProducts',
            'products_sold',
            'recent_sales',
            'recent_products',
            'nearlyExpiredCount',
            'expiredCount'
        ));
    }
}
