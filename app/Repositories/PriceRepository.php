<?php


namespace App\Repositories;


use Faker\Test\Provider\Collection;
use App\Price;
use Illuminate\Database\QueryException;

class PriceRepository implements PriceRepositoryInterface
{

    /**
     * Gets all prices
     *
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function get(){

        try{
            return Price::join('room_type', 'prices.room_type_id', '=', 'room_type.id')
                ->get([
                    'prices.id',
                    'amount',
                    'currency',
                    'type_name as room_type',
                    'prices.created_at'
                ])->sortBy('prices.created_at');
        }catch (QueryException $ex){
            return $ex->getMessage();
        }


    }

    /**
     * Gets price by ID
     *
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function getPriceByID($priceID){

        try{
            return Price::where('prices.id', $priceID)
              ->join('room_type', 'prices.room_type_id', '=', 'room_type.id')
                ->first([
                    'prices.id',
                    'amount',
                    'currency',
                    'type_name as room_type',
                    'prices.created_at'
                ]);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }


    }

    /**
     * Stores a price
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function store(array $data){

        try{
            return Price::create($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Edits a price by it's ID
     *
     * @param int $priceID
     * @param array $data
     *
     * @return int|string
     */
    public function update($priceID, array $data){

        try{
            return Price::where('id', '=', $priceID)->update($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Deletes a price by it's ID
     *
     * @param int $priceID
     * @return boolean|string
     */
    public function delete($priceID){

        try{
            return Price::destroy($priceID);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }


    }
}