<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Repositories\UserRepositoryInterface;

class UsersTableSeeder extends Seeder
{

    /**
     * The user repository instance.
     *
     * @var \App\Repositories\UserRepositoryInterface
     */
    protected $user;

    /**
     * HotelsTableSeeder constructor.
     *
     * @param HotelRepositoryInterface $hotel
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $this->user->store([
            'fullname' => $faker->name,
            'email' => 'johndoe@example.com',
            'password' => 'secret',
        ]);
    }
}
