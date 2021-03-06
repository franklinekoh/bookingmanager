<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\Room\RoomTypeRepositoryInterface;
use App\Room;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * The hotel repository instance.
     *
     * @var
     */
    protected $room;
    protected $roomType;
    /**
     * RoomsTableSeeder constructor.
     *
     * @param $room
     * @param $roomType
     */
    public function __construct(RoomRepositoryInterface $room, RoomTypeRepositoryInterface $roomType)
    {
        $this->room = $room;
        $this->roomType = $roomType;
    }

     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 10; $i++){



            $this->roomType->store([
               'type_name' => $faker->text(10)
            ]);


        }

        for($i = 0; $i < 10; $i++){
            $imageName = $i + 1;
            Room::create([
                'room_name' => strtoupper(str_random(3)).''.$i,
                'hotel_id' => 1,
                'room_type_id' => $i + 1,
                'room_image_path' => "uploads/room/room{$imageName}.jpg"
            ]);
        }

    }
}
