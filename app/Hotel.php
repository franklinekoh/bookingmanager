<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name', 'address', 'city', 'state', 'country', 'zipcode', 'phone', 'email', 'image_path'
    ];
}
