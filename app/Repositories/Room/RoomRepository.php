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
                        ->get(['rooms.id',
                            'room_name',
                            'hotel_id',
                            'room_type_id',
                            'is_available',
                            'rooms.created_at',
                            'type_name as room_type',
                            'name as hotel_name',
                            'address as hotel_address',
                            'city as hotel_city',
                            'state as hotel_state',
                            'country as hotel_country',
                            'zipcode',
                            'phone',
                            'email',
                            'image_path as hotel_image_path']);

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
     * @return Collection
     */
    public function getAvailableRooms(){
        return Room::where('is_available', 1)
             ->join('room_type', 'room_type.id', '=', 'rooms.room_type_id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->get(['rooms.id',
                'room_name',
                'hotel_id',
                'room_type_id',
                'is_available',
                'rooms.created_at',
                'type_name as room_type',
                'name as hotel_name',
                'address as hotel_address',
                'city as hotel_city',
                'state as hotel_state',
                'country as hotel_country',
                'zipcode',
                'phone',
                'email',
                'image_path as hotel_image_path']);
    }

    /**
     * Stores a room
     *
     * @param array $data
     */
    public function store(array $data){
            Room::create($data);
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