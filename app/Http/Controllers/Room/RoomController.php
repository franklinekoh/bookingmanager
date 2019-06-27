<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Http\Request;
use Validator;
use App\Utilities\ImageUtility;

class RoomController extends Controller
{

    /**
     * The room repository instance.
     *
     * @var \App\Repositories\Room\RoomRepositoryInterface
     */
    protected $room;

    /**
     * RoomRepository constructor.
     *
     * @param RoomRepositoryInterface $room
     */
    public function __construct(RoomRepositoryInterface $room)
    {
        $this->room = $room;
    }

    /**
     * Create get all rooms
     * @return mixed
     */

    public function getRooms(){
        $data = $this->room->get();

        return $data;
    }

    /**
     * Create room
     *
     * @param Request $request
     * @return mixed
     */
    public function createRoom(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'hotelID' => 'required|exists:hotels,id|numeric',
                'roomTypeID' => 'required|exists:room_type,id|numeric',
                'image' => 'required'
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $imageDestination = 'uploads/room';
        $imageUtility = new ImageUtility($request['image'], $imageDestination);

        $uploaded = $imageUtility->uploadPhoto();

        if(!$uploaded){
            return response()->json([
                'status' => false,
                'message' => 'Image data not uploaded successfully'
            ]);
        }

        $imagePath = $uploaded;

        $this->room->store([
            'room_name' => $request->input('name'),
            'hotel_id' => $request->input('hotelID'),
            'room_type_id' => $request->input('roomTypeID'),
            'room_image_path' => $imagePath
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Room created successfully',
            'data' => null
        ]);

    }
}
