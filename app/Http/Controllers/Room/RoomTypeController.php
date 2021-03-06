<?php

namespace App\Http\Controllers\Room;

use App\Repositories\Room\RoomTypeRepositoryInterface;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function editRoomType(Request $request){

        $validator = Validator::make($request->all(),
            [
                'roomTypeID' => 'required|numeric|exists:room_type,id',
                'type_name' => ''
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = [];

        if (array_key_exists('type_name', $request->all()))
            $data['type_name'] = $request->input('type_name');

       $updated = $this->roomType->update($request->input('roomTypeID'), $data);

        if (gettype($updated) != 'integer')
            return response()->json([
                'status' => false,
                'message' => $updated,
                'data' => null
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Room type edited successfully',
            'data' => null
        ]);
    }

    /**
     * Get room type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomTypes(){

        $data = $this->roomType->get();

        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);

    }

    /**
     * Get room type by it's ID
     *
     * @param $roomTypeID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomTypeByID($roomTypeID){

        $data = $this->roomType->getRoomTypeByID($roomTypeID);
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * Delete Room type
     *
     * @param $roomTypeID
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRoomType($roomTypeID){

        $request = [
            'roomTypeID' => $roomTypeID
        ];
        $validator = Validator::make($request,
            [
                'roomTypeID' => 'required|numeric|exists:room_type,id',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $this->roomType->delete($roomTypeID);

        return response()->json([
            'status' => true,
            'message' => 'Room type deleted successfully',
            'data' => null
        ]);

    }
}
