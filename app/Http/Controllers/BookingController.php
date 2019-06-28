<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use Validator;

class BookingController extends Controller
{
    /**
     * The book repository instance.
     *
     * @var \App\Repositories\BookingRepositoryInterface
     */
    protected $book;

    /**
     * The room repository instance.
     *
     * @var \App\Repositories\Room\RoomRepositoryInterface
     */
    protected $room;

    /**
     * BookingController constructor.
     *
     * @param BookingRepositoryInterface $book
     * @param RoomRepositoryInterface $room
     */
    public function __construct(BookingRepositoryInterface $book, RoomRepositoryInterface $room)
    {
        $this->book = $book;
        $this->room = $room;
    }


    /**
     * Gets booking details it's ID
     *
     * @param $bookingID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookingByID($bookingID){
        $request = [
            'bookingID' => $bookingID
        ];

        $validator = Validator::make($request,
            [
                'bookingID' => 'required|exists:bookings,id',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

       $data = $this->book->getBookingByID($bookingID);
       return response()->json([
           'status' => true,
           'message' => null,
           'data' => $data
       ]);
    }

    /**
     * Stores a booking
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBookings(Request $request){
        $validator = Validator::make($request->all(),
            [
                'roomID' => 'required|exists:rooms,id',
                'startDate' => 'required',
                'endDate' => 'required',
                'customerName' => 'required',
                'customerEmail' => 'required'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }
    }
}
