<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Repositories\HotelRepositoryInterface;
use App\Utilities\ImageUtility;
use File;

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
                'email' => 'email',
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = $request->all();
        $body = [];

        if (array_key_exists('name', $data))
            $body['name'] = $data['name'];

        if (array_key_exists('address', $data))
            $body['address'] = $data['address'];

        if (array_key_exists('city', $data))
            $body['city'] = $data['city'];

        if (array_key_exists('state', $data))
            $body['state'] = $data['state'];

        if (array_key_exists('zipcode', $data))
            $body['zipcode'] = $data['zipcode'];

        if (array_key_exists('country', $data))
            $body['country'] = $data['country'];

        if (array_key_exists('image', $data)){


        }


         $updated = $this->hotel->update($request->input('hotelID'), $body);
        if (!is_int($updated))
            return response()->json([
                'status' => false,
                'message' => $updated,
                'data' => null
            ]);

       return response()->json([
           'status' => true,
           'message' => 'Hotel edited successfully',
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
