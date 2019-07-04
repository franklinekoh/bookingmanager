<?php

use Illuminate\Database\Seeder;
use App\Repositories\HotelRepositoryInterface;
use Faker\Factory as Faker;

class HotelsTableSeeder extends Seeder
{

    /**
     * The hotel repository instance.
     *
     * @var \App\Repositories\HotelRepositoryInterface
     */
    protected $hotel;

    /**
     * HotelsTableSeeder constructor.
     *
     * @param HotelRepositoryInterface $hotel
     */
    public function __construct(HotelRepositoryInterface $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create();
        $this->hotel->store([
            'name' => $faker->company,
            'address' => $faker->address,
            'city' => $faker->city,
            'country' => $faker->country,
            'state' => $faker->state,
            'zipcode' => $faker->postcode,
            'phone' => $faker->phoneNumber,
            'email' => $faker->email,
            'image_path' => $faker->imageUrl()
        ]);
    }
}
