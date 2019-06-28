<?php


namespace App\Repositories;


interface BookingRepositoryInterface
{

    /**
     * Gets all bookings
     *
     */

    public function get();

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

    /**
     * Gets filtered bookings
     *
     * @param $year
     * @param $month
     */
    public function getFilteredBookings($year, $month = null);
}