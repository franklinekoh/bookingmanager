<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'room_id', 'start_date', 'end_date', 'customer_fullname', 'customer_email', 'phone', 'total_nights', 'total_price', 'user_id'
    ];
}
