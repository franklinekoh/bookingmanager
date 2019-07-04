<?php


namespace App\Repositories;


use Illuminate\Database\QueryException;
use App\Bookings;

class BookingRepository implements BookingRepositoryInterface
{

    /**
     * Gets all bookings
     *
     * @param $year
     * @param $month
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function get(){
        try{
          return  Bookings::Join('rooms', 'rooms.id', '=', 'bookings.room_id')
                        ->leftJoin('hotels', 'hotels.id', '=', 'rooms.hotel_id')
                            ->leftJoin('room_type', 'rooms.room_type_id', '=', 'room_type.id')
                                 ->get([
                                     'bookings.id',
                                     'customer_fullname',
                                     'customer_email',
                                     'name as hotel_name',
                                     'address as hotel_address',
                                     'room_name',
                                     'type_name as room_type',
                                     'total_nights',
                                     'total_price',
                                     'start_date',
                                     'end_date',
                                     'bookings.created_at'
                                 ]);

        }catch (QueryException $ex){
            return $ex->getMessage();
        }
    }

    /**
     * Gets filtered bookings
     *
     * @param $year
     * @param $month
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    public function getFilteredBookings($year, $month = null){
        try{
            if ($month !== null)
                return Bookings::whereYear('bookings.created_at', '=', $year)
                                ->whereMonth('bookings.created_at', '=', $month)
                                ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
                    ->leftJoin('hotels', 'hotels.id', '=', 'rooms.hotel_id')
                    ->leftJoin('room_type', 'rooms.room_type_id', '=', 'room_type.id')
                    ->get([
                        'bookings.id',
                        'customer_fullname',
                        'customer_email',
                        'name as hotel_name',
                        'address as hotel_address',
                        'room_name',
                        'type_name as room_type',
                        'total_nights',
                        'total_price',
                        'start_date',
                        'end_date',
                        'bookings.created_at'
                    ]);

                return Bookings::whereYear('bookings.created_at', '=', $year)
                    ->whereMonth('bookings.created_at', '=', $month)
                    ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
                    ->leftJoin('hotels', 'hotels.id', '=', 'rooms.hotel_id')
                    ->leftJoin('room_type', 'rooms.room_type_id', '=', 'room_type.id')
                    ->get([
                        'bookings.id',
                        'customer_fullname',
                        'customer_email',
                        'name as hotel_name',
                        'address as hotel_address',
                        'room_name',
                        'type_name as room_type',
                        'total_nights',
                        'total_price',
                        'start_date',
                        'end_date',
                        'bookings.created_at'
                    ]);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }

    }

    /**
     * Gets a booking by it's ID
     *
     * @param $bookingID
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function getBookingByID($bookingID){
        try{
         return  Bookings::where('bookings.id', $bookingID)
                     ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
                     ->leftJoin('hotels', 'hotels.id', '=', 'rooms.hotel_id')
                     ->leftJoin('room_type', 'rooms.room_type_id', '=', 'room_type.id')
                     ->leftJoin('prices', 'prices.room_type_id', '=', 'room_type.id')
                     ->first([
                         'rooms.id as room_id',
                         'bookings.id',
                         'customer_fullname',
                         'customer_email',
                         'name as hotel_name',
                         'address as hotel_address',
                         'room_name',
                         'type_name as room_type',
                         'total_nights',
                         'total_price',
                         'start_date',
                         'end_date',
                         'bookings.created_at',
                         'currency'
                     ]);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }
    }

    /**
     * Stores a booking
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|string
     */

    public function store(array $data){
        try{
            return Bookings::create($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }
    }

    /**
     * Edits a booking by it's ID
     *
     * @param int $bookingID
     * @param array $data
     * @return int|string
     */
    public function update($bookingID, array $data){
        try{
            return Bookings::where('id', $bookingID)->update($data);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }
    }

    /**
     * Deletes a deletes by it's ID
     *
     * @param int $bookingID
     * @return boolean|string
     */
    public function delete($bookingID){
        try{
            return Bookings::destroy($bookingID);
        }catch (QueryException $ex){
            return $ex->getMessage();
        }
    }
}