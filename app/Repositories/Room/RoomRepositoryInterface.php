<?php


namespace App\Repositories\Room;


interface RoomRepositoryInterface
{


    /**
     * Gets all rooms
     */
    public function get();

    /**
     * Gets a room by its ID
     *
     * @param $roomID
     */
    public function getRoomByID($roomID);

    /**
     * Gets available room
     */
    public function getAvailableRooms();

    /**
     * Stores a room
     *
     * @param array $data
     */
    public function store(array $data);

    /**
     * Edits a room by it's ID
     *
     * @param int $roomID
     * @param array $data
     */
    public function update($roomID, array $data);

    /**
     * Deletes a room type by it's ID
     * @param int $roomID
     */
    public function delete($roomID);

}