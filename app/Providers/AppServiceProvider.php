<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Tambahkan di bagian atas
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            if (Auth::check() && Auth::user()->role === 'paramedis') {
                $lowStockObat = \App\Models\Obat::where('stok', '<=', 5)->get();
                $expiringObat = \App\Models\Obat::whereBetween('expired_at', [now(), now()->addDays(30)])->get();
                $view->with(compact('lowStockObat', 'expiringObat'));
            }
        });
    }
}
