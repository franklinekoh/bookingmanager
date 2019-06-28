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
            return Bookings::all();
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
                return Bookings::whereYear('created_at', '=', $year)
                                ->whereMonth('created_at', '=', $month)->get();

                return Bookings::whereYear('created_at', '=', $year)->get();
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
         return  Bookings::find($bookingID);
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