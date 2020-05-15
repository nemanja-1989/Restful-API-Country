<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Create API resource for CountryController
Route::get("countries/truncate", "CountryController@truncate");
Route::apiResource("countries", "CountryController");

//Create API resource for CitizenController
Route::get("citizens/truncate", "CitizenController@truncate");
Route::apiResource("citizens", "CitizenController");