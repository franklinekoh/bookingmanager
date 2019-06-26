<?php
namespace App\Repositories;

use App\Hotel;

class HotelRepository implements HotelRepositoryInterface
{

    /**
     * Gets a Hotel by it's ID
     *
     * @param int
     * @return Collection
     */

    public function get($hotelID)
    {
        return Hotel::find($hotelID);
    }

    /**
     * Stores a hotel
     *
     * @param array
     * @return boolean
     */

    public function store(array $data)
    {
        return Hotel::create($data);
    }

    /**
     * Edits a hotel by it's ID
     *
     * @param int
     * @param array
     */

    public function update($hotelID, array $data)
    {
         Hotel::find($hotelID)->update($data);
    }
}