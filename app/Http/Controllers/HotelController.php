<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Repositories\HotelRepositoryInterface;

class HotelController extends Controller
{

    /**
     * The hotel repository instance.
     *
     * @var \App\Repositories\HotelRepositoryInterface
     */
    protected $hotel;

    /**
     * HotelController constructor.
     *
     * @param HotelRepositoryInterface $hotel
     */
    public function __construct(HotelRepositoryInterface $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * Gets Hotel details for hotel with it's ID
     *
     * @param $hotelID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHotel($hotelID){

        $request = [
            'hotelID' => $hotelID
        ];

        $validator = Validator::make($request,
            [
            'hotelID' => 'required|exists:hotels,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = $this->hotel->get($hotelID);

       return response()->json([
          'status' => true,
          'message' => null,
          'data' => $data
       ]);

    }

    /**
     * Edits hotel details with it's ID
     *
     * @param $request Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editHotel(Request $request){

        $validator = Validator::make($request->all(),
            [
                'hotelID' => 'required|numeric|exists:hotels,id',
                'data' => 'required'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

         $updated = $this->hotel->update($request->input('hotelID'), $request->input('data'));
        if (gettype($updated) != 'integer')
            return response()->json([
                'status' => false,
                'message' => $updated,
                'data' => null
            ]);

       return response()->json([
           'status' => true,
           'message' => 'Movie edited successfully',
           'data' => null
       ]);
    }

    /**
     * Get All hotels
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllHotels(){

        $data = $this->hotel->getAllHotel();
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }
}
