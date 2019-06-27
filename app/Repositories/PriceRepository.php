<?php


namespace App\Repositories;


use Faker\Test\Provider\Collection;
use App\Price;

class PriceRepository implements PriceRepositoryInterface
{

    /**
     * Gets all prices
     *
     * @return Collection;
     */

    public function get(){
        return Price::join('room_type', 'prices.room_type_id', '=', 'room_type.id')
                    ->get([
                        'amount',
                        'currency',
                        'type_name as room_type',
                        'prices.created_at'
                    ]);
    }

    /**
     * Stores a price
     *
     * @param array $data
     */

    public function store(array $data){
        Price::create($data);
    }

    /**
     * Edits a price by it's ID
     *
     * @param int $priceID
     * @param array $data
     */
    public function update($priceID, array $data){
        Price::find($priceID)->update($data);
    }

    /**
     * Deletes a price by it's ID
     *
     * @param int $priceID
     */
    public function delete($priceID){
        Price::destroy($priceID);
    }
}