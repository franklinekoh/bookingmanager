<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\BookingRepositoryInterface;
use Validator;
use App\Utilities\BookingUtility;
use App\Repositories\Room\RoomRepository;

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
     * @var \App\Utilities\BookingUtilityInterface
     */

    public function __construct(BookingRepositoryInterface $book)
    {
        $this->book = $book;
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
    public function storeBooking(Request $request, $userID = null){
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

        $bookingUtility = new BookingUtility(
            $request->input('startDate'),
            $request->input('endDate'),
            $request->input('roomID'),
            new RoomRepository());

        if (!$bookingUtility->checkRoomAvailability())
            return response()->json([
                'status' => false,
                'message' => 'The selected room is not available',
                'data' => null
            ]);

        $totalNights = $bookingUtility->getTotalNights();
        $totalPrice = $bookingUtility->getTotalPrice();

       $data = $this->book->store([
            'room_id' => $request->input('roomID'),
            'start_date' => Carbon::parse($request->input('startDate')),
            'end_date' => Carbon::parse($request->input('endDate')),
            'customer_fullname' => $request->input('customerName'),
            'customer_email' => $request->input('customerEmail'),
            'total_nights' => $totalNights,
            'total_price' => $totalPrice['amount'],
            'user_id' => $userID
        ]);


        if (gettype($data) == 'string')
            return response()->json([
                'status' => false,
                'message' => $data
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Booking created successfully',
            'data' => $data
        ]);
    }

    /**
     * Stores a booking for unregisteredUsers
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBookingForUnregisteredUsers(Request $request){
       return $this->storeBooking($request);
    }

    /**
     * Stores a booking for registeredUsers
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function storeBookingForRegisteredUsers(Request $request){
       return $this->storeBooking($request, auth()->user()->id);
    }
}
