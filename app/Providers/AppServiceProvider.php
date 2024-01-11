<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

//        if (config('app.debug')) {
//            DB::listen(function ($query) {
//                \Log::info('Query: ' . $query->sql);
//                \Log::info('Bindings: ' . json_encode($query->bindings));
//                \Log::info('Time: ' . $query->time);
//            });
//        }
    }
}
