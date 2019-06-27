<?php


namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Stores a user
     *
     * @param array $data
     *
     * @return Collection;
     */

    public function store(array $data){
       return User::create($data);
    }
}