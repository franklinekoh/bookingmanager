<?php

namespace App\Http\Controllers;

use App\Repositories\PriceRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class PriceController extends Controller
{
    /**
     * The Price repository instance.
     *
     * @var \App\Repositories\PriceRepositoryInterface
     */
    protected $price;

    /**
     * PriceController constructor.
     *
     * @param PriceRepositoryInterface $price
     */
    public function __construct(PriceRepositoryInterface $price)
    {
        $this->price = $price;
    }

    /**
     * Gets Prices all room types
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getPrices(){
        $data = $this->price->get();

        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * creates price for a room
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPrice(Request $request){

        $validator = Validator::make($request->all(),
            [
                'roomTypeID' => 'required|numeric|exists:room_type,id|unique:prices,room_type_id',
                'currency' => 'required',
                'amount' => 'required|numeric'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $this->price->store([
           'amount' => $request->input('amount'),
            'currency' => $request->input('currency'),
            'room_type_id' => $request->input('roomTypeID')
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Price created successfully',
            'data' => null
        ]);
    }

    /**
     * edit price for a room
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPrice(Request $request){

        $validator = Validator::make($request->all(),
            [
                'priceID' => 'required|numeric|exists:prices,id',
                'amount' => '',
                'currency' => '',
                'room_type_id' => 'exists:room_type,id|unique:prices,room_type_id'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = [];

        if (array_key_exists('amount', $request->all()))
            $data['amount'] = $request->input('amount');

        if (array_key_exists('currency', $request->all()))
            $data['currency'] = $request->input('currency');

        if (array_key_exists('room_type_id', $request->all()))
            $data['room_type_id'] = $request->input('room_type_id');

       $updated = $this->price->update($request->input('priceID'), $data);

        if (gettype($updated) != 'integer')
            return response()->json([
                'status' => false,
                'message' => $updated,
                'data' => null
            ]);


        return response()->json([
            'status' => true,
            'message' => 'Price edited successfully',
            'data' => null
        ]);
    }

    /**
     * delete price for a room
     *
     * @param $priceID
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePrice($priceID){

        $request = [
            'priceID' => $priceID
        ];
        $validator = Validator::make($request,
            [
                'priceID' => 'required|numeric|exists:prices,id'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $this->price->delete($request['priceID']);

        return response()->json([
            'status' => true,
            'message' => 'Price delete successfully',
            'data' => null
        ]);
    }

    public function getPriceByID($priceID){
        $data = $this->price->getPriceByID($priceID);

        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }
}
