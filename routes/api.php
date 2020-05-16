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
Route::get("citizens", "CitizenController@allCitizens");
Route::get("citizens/truncate", "CitizenController@truncate");
Route::apiResource("countries/{country}/citizens", "CitizenController");

//Create API resource for NumberController
Route::get("numbers", "NumberController@allNumbers");
Route::get("numbers/truncate", "NumberController@truncate");
Route::apiResource("citizens/{citizen}/numbers", "NumberController");

//Create API resource for CountryBlogController
Route::get("country_blogs", "CountryBlogController@allCountryBlogs");
Route::get("country_blogs/truncate", "CountryBlogController@truncate");
Route::apiResource("citizens/{citizen}/country_blogs", "CountryBlogController");
