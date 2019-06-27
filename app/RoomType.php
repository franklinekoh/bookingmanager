<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{

    /**
     * The attributes that defines table
     *
     * @var array
     */
    protected $table = 'room_type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'type_name'
    ];
}
