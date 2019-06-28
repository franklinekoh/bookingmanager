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

    public function getBookings(){

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
                'data' => 'required'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $validationMessage = [];
        if (array_key_exists('total_nights', $request->input('data')))
            $validationMessage[] = 'total_nights can not be edited. Please remove from request signature';

        if (array_key_exists('total_price', $request->input('data')))
            $validationMessage[] = 'total_price can not be edited. Please remove from request signature';

        if (array_key_exists('user_id', $request->input('data')))
            $validationMessage[] = 'user_id can not be edited. Please remove from request signature';

        if (!empty($validationMessage))
            return response()->json([
                'status' => false,
                'message' => $validationMessage
            ]);

        $totalPrice = null;
        $totalNights = null;
        $booking = $this->book->getBookingByID($request->input('bookingID'));

        if (array_key_exists('start_date', $request->input('data')) && !array_key_exists('end_date', $request->input('data'))){
            $bookingUtility = new BookingUtility(
                $request->input('data')['start_date'],
                $booking->end_date,
                $booking->room_id,
                new RoomRepository());

            $totalNights = $bookingUtility->getTotalNights();
            $totalPrice = $bookingUtility->getTotalPrice();
        }

        if (array_key_exists('end_date', $request->input('data')) && !array_key_exists('start_date', $request->input('data'))){
            $bookingUtility = new BookingUtility(
                $booking->start_date,
                $request->input('data')['end_date'],
                $booking->room_id,
                new RoomRepository());

            $totalNights = $bookingUtility->getTotalNights();
            $totalPrice = $bookingUtility->getTotalPrice();

        }

        if (array_key_exists('start_date', $request->input('data')) && array_key_exists('end_date', $request->input('data'))){
            $bookingUtility = new BookingUtility(
                $request->input('data')['start_date'],
                $request->input('data')['end_date'],
                $booking->room_id,
                new RoomRepository());

            $totalNights = $bookingUtility->getTotalNights();
            $totalPrice = $bookingUtility->getTotalPrice();
        }

        $data = $request->input('data');
        if ($totalNights !== null){
            $data['total_nights'] = $totalNights;
        }

        if ($totalPrice !== null)
            $data['total_price'] = $totalPrice['amount'];

        $updated = $this->book->update($request->input('bookingID'), $data);

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBooking(Request $request){

        $validator = Validator::make($request->all(),
            [
                'bookingID' => 'required|exists:bookings,id',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $this->book->delete($request->input('bookingID'));

        return response()->json([
            'status' => true,
            'message' => 'booking deleted successfully'
        ]);
    }
}
