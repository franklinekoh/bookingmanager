<?php

namespace App\Http\Controllers;

use App\Repositories\RoomTypeRepositoryInterface;
use App\RoomType;
use Illuminate\Http\Request;
use Validator;

class RoomTypeController extends Controller
{

    /**
     * The hotel repository instance.
     *
     * @var \App\Repositories\HotelRepositoryInterface
     */
    protected $roomType;

    /**
     * HotelController constructor.
     *
     * @param RoomTypeRepositoryInterface $roomType
     */
    public function __construct(RoomTypeRepositoryInterface $roomType)
    {
        $this->roomType = $roomType;
    }
    /**
     * Create room type
     *
     * @param Request $request
     * @return mixed
     */
    public function createRoomType(Request $request){

        $validator = Validator::make($request->all(),
            [
                'typeName' => 'required|unique:room_type,type_name',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $this->roomType->store([
            'type_name' => $request->input('typeName')
        ]);
        return response()->json([
            'status' => true,
            'message' => 'room type created successfully',
            'data' => null
        ]);
    }

    /**
     * Update room type
     *
     * @param Request $request
     * @return mixed
     */
    public function editRoomType(Request $request){

        $validator = Validator::make($request->all(),
            [
                'roomTypeID' => 'required|numeric|exists:room_type,id',
                'data' => 'required'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $this->roomType->update($request->input('roomTypeID'), $request->input('data'));

        return response()->json([
            'status' => true,
            'message' => 'Room type edited successfully',
            'data' => null
        ]);
    }

    /**
     * Get room type
     * @return mixed
     */
    public function getRoomType(){

    }

    /**
     * Delete Room type
     *
     * @param $roomTypeID
     * @return void
     */
    public function deleteRoomType($roomTypeID){

    }
}
