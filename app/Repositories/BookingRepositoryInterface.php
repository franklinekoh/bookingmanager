<?php


namespace App\Repositories;


interface BookingRepositoryInterface
{

    /**
     * Gets all bookings
     *
     * @param $year
     * @param $month
     */

    public function get($year, $month);

    /**
     * Gets a booking by it's ID
     *
     * @param $bookingID
     */

    public function getBookingByID($bookingID);

    /**
     * Stores a booking
     *
     * @param array $data
     */

    public function store(array $data);

    /**
     * Edits a booking by it's ID
     *
     * @param int $bookingID
     * @param array $data
     */
    public function update($bookingID, array $data);

    /**
     * Deletes a deletes by it's ID
     *
     * @param int $bookingID
     */
    public function delete($bookingID);
}