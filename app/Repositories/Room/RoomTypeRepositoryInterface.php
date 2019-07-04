<?php
namespace App\Repositories\Room;

interface RoomTypeRepositoryInterface{

    /**
     * Gets all room types
     */
    public function get();

        /**
         * Get room type by ID
         *
         * @param $roomTypeID
         */
    public function getRoomTypeByID($roomTypeID);

    /**
     * Stores a room type
     *
     * @param array $data
     */
    public function store(array $data);

    /**
     * Edits a room type by it's ID
     *
     * @param int $roomTypeID
     * @param array $data
     */
    public function update($roomTypeID, array $data);

    /**
     * Deletes a room type by it's ID
     * @param int $roomTypeID
     */
    public function delete($roomTypeID);

}