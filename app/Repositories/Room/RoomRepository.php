<?php


namespace App\Repositories\Room;

use App\Room;
use mysql_xdevapi\Collection;


class RoomRepository implements RoomRepositoryInterface
{

    /**
     * Gets all rooms
     * @return Collection
     */
    public function get(){
        return Room::join('room_type', 'room_type.id', '=', 'rooms.room_type_id')
                    ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
                        ->get();
    }

    /**
     * Gets a room by its ID
     *
     * @param $roomID
     * @return Collection
     */
    public function getRoomByID($roomID){
        return Room::find($roomID)->get();
    }

    /**
     * Gets available room
     *
     * @param $roomID
     * @return Collection
     */
    public function getAvailableRooms($roomID){
//        return Room::find($roomID)
//                    where('')->get();
    }

    /**
     * Stores a room
     *
     * @param array $data
     */
    public function store(array $data){

    }

    /**
     * Edits a room by it's ID
     *
     * @param int $roomID
     * @param array $data
     */
    public function update($roomID, array $data){

    }

    /**
     * Deletes a room type by it's ID
     * @param int $roomID
     */
    public function delete($roomID){

    }
}