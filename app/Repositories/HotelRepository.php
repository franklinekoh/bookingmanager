<?php
namespace App\Repositories;

use App\Hotel;
use Illuminate\Database\QueryException;

class HotelRepository implements HotelRepositoryInterface
{

    /**
     * Gets a Hotel by it's ID
     *
     * @param int
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function get($hotelID)
    {
        try{
            return Hotel::find($hotelID);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Stores a hotel
     *
     * @param array
     * @return boolean
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function store(array $data)
    {
        try{
            return Hotel::create($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Edits a hotel by it's ID
     *
     * @param int
     * @param array
     * @return int|string
     */

    public function update($hotelID, array $data)
    {
        try{
            return Hotel::where('id', $hotelID)->update($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }
}