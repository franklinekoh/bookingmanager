<?php

namespace App\Http\Controllers;

use App\Repositories\Room\RoomRepositoryInterface;
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
     * The book repository instance.
     *
     * @var \App\Repositories\RoomRepositoryInterface
     */
    protected $room;

    /**
     * The room repository instance.
     *
     * @var \App\Utilities\BookingUtilityInterface
     * @param $room
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
    public function storeBooking(Request $request, $userID = null){
        $validator = Validator::make($request->all(),
            [
                'roomID' => 'required|exists:rooms,id',
                'startDate' => 'required',
                'endDate' => 'required',
                'customerName' => 'required',
                'customerEmail' => 'required',
                'totalNights' => 'required',
                'totalPrice' => 'required',
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

        $this->room->update($request->input('roomID'), [
            'is_available' => 0
        ]);

       $data = $this->book->store([
            'room_id' => $request->input('roomID'),
            'start_date' => Carbon::parse($request->input('startDate')),
            'end_date' => Carbon::parse($request->input('endDate')),
            'customer_fullname' => $request->input('customerName'),
            'customer_email' => $request->input('customerEmail'),
            'total_nights' => $request->input('totalNights'),
            'total_price' => $request->input('totalPrice'),
            'user_id' => $userID,
            'phone' => ($request->has('phone'))?$request->input('phone'):null
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

    /**
     * Stores all Bookings
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookings(){
       $data = $this->book->get();

        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * Gets filtered
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilteredBookings(Request $request){

        $validator = Validator::make($request->all(),
            [
                'year' => 'required|numeric'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = $this->book->getFilteredBookings($request->input('year'), ($request->has('month'))?$request->input('month'):null);
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * Edits an existing booking
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  editBooking(Request $request){
        $validator = Validator::make($request->all(),
            [
                'bookingID' => 'required|exists:bookings,id',
                'roomID' => 'required|exists:rooms,id',
                'startDate' => 'required',
                'endDate' => 'required',
                'customerName' => 'required',
                'customerEmail' => 'required',
                'totalNights' => 'required',
                'totalPrice' => 'required',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }


        $updated = $this->book->update($request->input('bookingID'), [
            'room_id' => $request->input('roomID'),
            'start_date' => Carbon::parse($request->input('startDate')),
            'end_date' => Carbon::parse($request->input('endDate')),
            'customer_fullname' => $request->input('customerName'),
            'customer_email' => $request->input('customerEmail'),
            'total_nights' => $request->input('totalNights'),
            'total_price' => $request->input('totalPrice')
        ]);

        if (is_string($updated))
            return response()->json([
            'status' => false,
            'message' => $updated
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Booking updated successfully',
            'data' => null
        ]);


    }

    /**
     * Deletes existing booking
     *
     * @param $bookingID
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBooking($bookingID){

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

        $roomID = $this->book->getBookingByID($bookingID)->room_id;
        $this->room->update($roomID, [
            'is_available' => 1
        ]);
        $this->book->delete($bookingID);

        return response()->json([
            'status' => true,
            'message' => 'booking deleted successfully'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalNightAndPrice(Request $request){

        $validator = Validator::make($request->all(),
            [
                'roomID' => 'required|exists:rooms,id',
                'startDate' => 'required',
                'endDate' => 'required'
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

        $totalNights = $bookingUtility->getTotalNights();
        $totalPrice = $bookingUtility->getTotalPrice();

        return response()->json([
            'status' => true,
            'message' => null,
            'data' => [
                'total_nights' => $totalNights,
                'total_price' => $totalPrice
            ]
        ]);
    }
}
