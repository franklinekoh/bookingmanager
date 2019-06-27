<?php
namespace App\Repositories;

interface HotelRepositoryInterface
{

    /**
     * Gets a Hotel by it's ID
     *
     * @param int $hotelID
     */

    public function get($hotelID);

    /**
     * Stores a hotel
     *
     * @param array $data
     */

    public function store(array $data);

    /**
     * Edits a hotel by it's ID
     *
     * @param int $hotelID
     * @param array $data
     */
    public function update($hotelID, array $data);

}