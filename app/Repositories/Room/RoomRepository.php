<?php


namespace App\Repositories\Room;

use App\Room;
use Illuminate\Database\QueryException;

class RoomRepository implements RoomRepositoryInterface
{

    /**
     * Gets all rooms
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function get(){
        try{
            return Room::join('room_type', 'room_type.id', '=', 'rooms.room_type_id')
                ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
                ->leftJoin('prices', 'room_type.id', '=', 'prices.room_type_id')
                ->get(['rooms.id',
                    'room_name',
                    'hotel_id',
                    'rooms.room_type_id',
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
                    'image_path as hotel_image_path',
                    'amount',
                    'currency']);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }


    }

    /**
     * Gets a room by its ID
     *
     * @param $roomID
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function getRoomByID($roomID){
        try{
            return  Room::find($roomID)
                ->join('room_type', 'room_type.id', '=', 'rooms.room_type_id')
                ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
                ->leftJoin('prices', 'room_type.id', '=', 'prices.room_type_id')
                ->first(['rooms.id',
                    'room_name',
                    'hotel_id',
                    'rooms.room_type_id',
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
                    'image_path as hotel_image_path',
                    'amount',
                    'currency']);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Gets available rooms
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function getAvailableRooms(){
        try{
            return Room::where('is_available', 1)
                ->join('room_type', 'room_type.id', '=', 'rooms.room_type_id')
                ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
                ->leftJoin('prices', 'room_type.id', '=', 'prices.room_type_id')
                ->get(['rooms.id',
                    'room_name',
                    'hotel_id',
                    'rooms.room_type_id',
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
                    'image_path as hotel_image_path',
                    'amount',
                    'currency']);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Gets available room by it's ID
     *
     * @param $roomID
     * @return boolean|string
     */
    public function checkRoomAvailability($roomID){
        try{
            return Room::where('id', $roomID)->first('is_available')->is_available;
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Stores a room
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function store(array $data){
        try{
            Room::create($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Edits a room by it's ID
     *
     * @param int $roomID
     * @param array $data
     * @return int|string
     */
    public function update($roomID, array $data){
        try{
            Room::where('id', $roomID)->update($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Deletes a room type by it's ID
     * @param int $roomID
     * @return boolean|string
     */
    public function delete($roomID){
        try{

        }catch (QueryException $ex){
            return $ex->getMessage();
        }
        Room::destroy($roomID);
    }
}