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

Route::resources([
    "devices" => "DeviceController",
    "plants" => "PlantController",
    "events" => "EventController",
    "gardens" => "GardenController",
    "tasks" => "TaskController"
]);

Route::middleware('devicesecret')->group(function() {
    Route::get("devices/{id}/config", "DeviceController@config");
    Route::post("devices/{id}/execute", "DeviceController@execute");
});