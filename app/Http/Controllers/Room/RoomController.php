<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class RoomController extends Controller
{

    /**
     * The room repository instance.
     *
     * @var \App\Repositories\Room\RoomRepositoryInterface
     */
    protected $room;

    /**
     * RoomRepository constructor.
     *
     * @param RoomRepositoryInterface $room
     */
    public function __construct(RoomRepositoryInterface $room)
    {
        $this->room = $room;
    }


    public function getRooms(){

        $data = $this->room->get();

        return $data;
    }
}
