<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Room;
use Illuminate\Http\Request;
use Validator;
use App\Utilities\ImageUtility;
use File;

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
     * @return \Illuminate\Http\JsonResponse
     */

    public function getRooms(){

        $data = $this->room->get();
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * Create room
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * get available rooms
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableRooms(){

        $data = $this->room->getAvailableRooms();
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * get individual room
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomByID($id){

        $request = [
            'roomID' => $id
        ];

        $validator = Validator::make($request,
            [
                'roomID' => 'required|exists:rooms,id',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = $this->room->getRoomByID($id);
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => $data
        ]);
    }

    /**
     * Edit room
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editRoom(Request $request){

        $validator = Validator::make($request->all(),
            [
                'roomID' => 'required|exists:rooms,id',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $data = [];
        if(array_key_exists('room_name', $request->all()))
            $data['room_name'] = $request->input('room_name');

        if(array_key_exists('hotel_id', $request->all()))
            $data['hotel_id'] = $request->input('hotel_id');

        if(array_key_exists('room_type_id', $request->all()))
            $data['room_type_id'] = $request->input('room_type_id');

        if(array_key_exists('image', $request->all())){

            $imageDestination = 'uploads/hotel';
            $imageUtility = new ImageUtility($request['image'], $imageDestination);

            $uploaded = $imageUtility->uploadPhoto();

            if(!$uploaded){
                return response()->json([
                    'status' => false,
                    'message' => 'Image data not uploaded successfully'
                ]);
            }

            $data['room_image_path'] = $uploaded;

            $currentImage = $this->room->getRoomByID($request->input('roomID'))->room_image_path;
            if(File::exists(public_path($currentImage)))
                unlink(public_path($currentImage));
        }


       $updated = $this->room->update($request->input('roomID'), $data);

        if (gettype($updated) != 'integer')
            return response()->json([
                'status' => false,
                'message' => $updated,
                'data' => null
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Room edited successfully',
            'data' => null
        ]);
    }

    /**
     * Delete room
     *
     * @param $roomID
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteRoom($roomID){

        $request = [
            'roomID' => $roomID
        ];
        $validator = Validator::make($request,
            [
                'roomID' => 'required|exists:rooms,id',
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $this->room->delete($request['roomID']);

        return response()->json([
            'status' => true,
            'message' => 'Room deleted successfully',
            'data' => null
        ]);
    }
}
