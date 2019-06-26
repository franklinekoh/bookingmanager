<?php
namespace App\Repositories;

interface HotelRepositoryInterface
{

    /**
     * Gets a Hotel by it's ID
     *
     * @param int
     */

    public function get($hotelID);

    /**
     * Stores a hotel
     *
     * @param array
     */

    public function store(array $data);

    /**
     * Edits a hotel by it's ID
     *
     * @param int
     * @param array
     */
    public function update($hotelID, array $data);

}