<?php


namespace App\Repositories;


interface UserRepositoryInterface
{

    /**
     * Stores a user
     *
     * @param array $data
     */

    public function store(array $data);
}