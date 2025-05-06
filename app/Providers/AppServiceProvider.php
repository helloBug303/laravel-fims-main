<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $outOfStockCount = Product::where('quantity', '<=', 0)->count();
            $lowStockCount = Product::where('quantity', '>', 0)->where('quantity', '<=', 5)->count(); // Add this line
            $expiredCount = Product::whereDate('expiry_date', '<=', Carbon::today())->count();
            $nearExpiryCount = Product::whereDate('expiry_date', '<=', Carbon::today()->copy()->addDays(7))
                                      ->whereDate('expiry_date', '>', Carbon::today())
                                      ->count();
    
            $dailySalesCount = Sale::whereDate('date', Carbon::today())->count();
            $monthlySalesCount = Sale::whereYear('date', Carbon::today()->year)
                                     ->whereMonth('date', Carbon::today()->month)
                                     ->count();
    
            $view->with([
                'outOfStockCount' => $outOfStockCount,
                'lowStockCount' => $lowStockCount, 
                'expiredCount' => $expiredCount,
                'nearExpiryCount' => $nearExpiryCount,
                'dailySalesCount' => $dailySalesCount,
                'monthlySalesCount' => $monthlySalesCount,
            ]);
        });
    }
    
}