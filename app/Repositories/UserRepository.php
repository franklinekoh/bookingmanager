<?php


namespace App\Repositories;

use App\User;
use Illuminate\Database\QueryException;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Stores a user
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function store(array $data){

        try{
            return User::create($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }
}