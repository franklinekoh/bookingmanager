<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * All routes related to hotel
 */
Route::prefix('hotel')->group(function () {

    Route::get('/{hotelID}', 'HotelController@getHotel');

    Route::get('/', 'HotelController@getAllHotels');

    Route::post('/', 'HotelController@editHotel');
});

/**
 * All routes related to room
 */
Route::prefix('room')->group(function () {

    Route::post('type', 'Room\RoomTypeController@createRoomType');

    Route::put('type', 'Room\RoomTypeController@editRoomType');

    Route::get('type', 'Room\RoomTypeController@getRoomTypes');

    Route::get('type/{id}', 'Room\RoomTypeController@getRoomTypeByID');

    Route::delete('type/{id}', 'Room\RoomTypeController@deleteRoomType');

    Route::get('/', 'Room\RoomController@getRooms');

    Route::get('/{id}', 'Room\RoomController@getRoomByID');

    Route::post('/', 'Room\RoomController@createRoom');

    Route::get('get/available', 'Room\RoomController@getAvailableRooms');

    Route::post('/edit', 'Room\RoomController@editRoom');

    Route::delete('/{id}', 'Room\RoomController@deleteRoom');

});

/**
 * All routes related to prices
 */
Route::prefix('price')->group(function () {

    Route::get('/', 'PriceController@getPrices');

    Route::post('/', 'PriceController@createPrice');

    Route::get('/{priceID}', 'PriceController@getPriceByID');

    Route::put('/', 'PriceController@editPrice');

    Route::delete('/{priceID}', 'PriceController@deletePrice');
});

/**
 * All routes related to authentication
 */

Route::post('register', 'AuthController@register');

Route::group([
    'prefix' => 'auth'
], function () {

    Route::get('user', 'AuthController@getUser');

    Route::post('login', 'AuthController@login');

    Route::post('logout', 'AuthController@logout');

    Route::post('refresh', 'AuthController@refresh');

    Route::post('me', 'AuthController@me');

});

/**
 * All routes related to booking
 */
Route::group([
//    'middleware' => 'auth:api',
    'prefix' => 'bookings'
], function () {

    Route::get('/', 'BookingController@getBookings');

    Route::get('/filter', 'BookingController@getFilteredBookings');

    Route::get('/{bookingID}', 'BookingController@getBookingByID');

    Route::post('/total', 'BookingController@getTotalNightAndPrice');

    Route::post('user/', 'BookingController@storeBookingForRegisteredUsers');

    Route::put('/', 'BookingController@editBooking');

    Route::delete('/{bookingID}', 'BookingController@deleteBooking');

});

Route::post('bookings/visitor/', 'BookingController@storeBookingForUnregisteredUsers');