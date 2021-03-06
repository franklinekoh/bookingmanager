<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Repositories\HotelRepositoryInterface;
use App\Repositories\HotelRepository;

use App\Repositories\Room\RoomTypeRepositoryInterface;
use App\Repositories\Room\RoomTypeRepository;

use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\Room\RoomRepository;

use App\Repositories\PriceRepositoryInterface;
use App\Repositories\PriceRepository;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;

use App\Repositories\BookingRepositoryInterface;
use App\Repositories\BookingRepository;


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

        $this->app->bind(
            RoomRepositoryInterface::class,
            RoomRepository::class);

        $this->app->bind(
            PriceRepositoryInterface::class,
            PriceRepository::class);

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class);

        $this->app->bind(
            BookingRepositoryInterface::class,
            BookingRepository::class);

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
