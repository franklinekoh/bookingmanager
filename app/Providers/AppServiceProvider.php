<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Repositories\HotelRepositoryInterface;
use App\Repositories\HotelRepository;

use App\Repositories\RoomTypeRepositoryInterface;
use App\Repositories\RoomTypeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            HotelRepositoryInterface::class,
        HotelRepository::class);

        $this->app->bind(
            RoomTypeRepositoryInterface::class,
            RoomTypeRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
