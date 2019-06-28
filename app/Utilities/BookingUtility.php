<?php


namespace App\Utilities;

use App\Repositories\Room\RoomRepositoryInterface;
use Carbon\Carbon;

class BookingUtility
{

    /**
     * Room Repository instance
     * @var
     */
    private $room;

    /**
     * Room ID
     * @var
     */
    private $roomID;

    /**
     * Start Date
     * @var
     */
    private $startDate;

    /**
     * End Date
     * @var
     */
    private $endDate;

    /**
     * BookingUtility class constructor.
     *
     * @param $roomID
     * @param $startDate
     * @param $endDate
     * @param RoomRepositoryInterface $room
     */
    public function __construct($startDate, $endDate, $roomID, RoomRepositoryInterface $room)
    {
        $this->roomID = $roomID;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->room = $room;
    }


    /**
     * Returns total price of a booking
     *
     * @return array
     */
    public function getTotalPrice(){
        return [
            'amount' => $this->room->getRoomByID($this->roomID)->amount * $this->getTotalNights(),
            'currency' => $this->room->getRoomByID($this->roomID)->currency
        ];
    }


    /**
     * Returns total nights of a booking
     *
     * @return int
     */
    public function getTotalNights(){

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return $endDate->diffInDays($startDate);

    }

    /**
     * Checks if room is available
     *
     * @return boolean
     */
    public function checkRoomAvailability(){
      return  $this->room->checkRoomAvailability($this->roomID);
    }
}