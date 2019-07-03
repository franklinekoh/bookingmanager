<?php


namespace App\Repositories;


interface PriceRepositoryInterface
{

    /**
     * Gets all prices
     */

    public function get();

    /**
     * Gets price by it's ID
     */

    public function getPriceByID($priceID);

    /**
     * Stores a price
     *
     * @param array $data
     */

    public function store(array $data);

    /**
     * Edits a price by it's ID
     *
     * @param int $priceID
     * @param array $data
     */
    public function update($priceID, array $data);

    /**
     * Deletes a price by it's ID
     *
     * @param int $priceID
     */
    public function delete($priceID);
}