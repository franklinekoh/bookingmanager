<?php

namespace App\Repositories;

use App\RoomType;


class RoomTypeRepository implements RoomTypeRepositoryInterface
{

    /**
     * Gets all room types
     *
     * @return Object
     */
    public function get(){
        return RoomType::all();
    }

    /**
     * Stores a room type
     *
     * @param array $data
     */
    public function store(array $data){
         RoomType::create($data);
    }

    /**
     * Edits a room type by it's ID
     *
     * @param int $roomTypeID
     * @param array $data
     */
    public function update($roomTypeID, array $data){
         RoomType::find($roomTypeID)->update($data);
    }

    /**
     * Deletes a room type by it's ID
     * @param int $roomTypeID
     */
    public function delete($roomTypeID){
        RoomType::find($roomTypeID)->delete();
    }
}