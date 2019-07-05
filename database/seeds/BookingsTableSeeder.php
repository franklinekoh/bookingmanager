<?php

use Illuminate\Database\Seeder;
use App\Repositories\BookingRepositoryInterface;
use Faker\Factory as Faker;
use App\Bookings;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    /**
     * @var BookingRepositoryInterface
     */
    protected $booking;

    /**
     * BookingsTableSeeder constructor.
     * @param BookingRepositoryInterface $booking
     */
    public function __construct(BookingRepositoryInterface $booking)
    {
        $this->booking = $booking;
    }

    public function run()
    {
        //
        $faker = Faker::create();
        for($i = 0; $i < 10; $i++){
            Bookings::create([
                'room_id' => $i + 1,
                'start_date' => $faker->dateTime(),
                'end_date' => $faker->dateTime(),
                'customer_fullname' => $faker->name,
                'customer_email' => $faker->email,
                'total_nights' => $faker->numberBetween(1, 100),
                'total_price' => $faker->numberBetween(1000, 1000000)
            ]);
        }

    }
}
