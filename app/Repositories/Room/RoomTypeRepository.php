<?php

namespace App\Repositories\Room;

use App\RoomType;
use Illuminate\Database\QueryException;


class RoomTypeRepository implements RoomTypeRepositoryInterface
{

    /**
     * Gets all room types
     *
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function get(){
        try{
            return RoomType::all();
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Stores a room type
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function store(array $data){
        try{
            RoomType::create($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Edits a room type by it's ID
     *
     * @param int $roomTypeID
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function update($roomTypeID, array $data){
        try{
            RoomType::where('id', $roomTypeID)->update($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Deletes a room type by it's ID
     *
     * @param int $roomTypeID
     * @return boolean|string
     */
    public function delete($roomTypeID){
        try{
           return RoomType::destroy($roomTypeID);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }
}