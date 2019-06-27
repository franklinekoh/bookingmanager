<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'room_name', 'address', 'city', 'state', 'country', 'zipcode', 'phone', 'email', 'image_path'
    ];
}
