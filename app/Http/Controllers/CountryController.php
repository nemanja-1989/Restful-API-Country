<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $countries = Country::get();

        //return response()->json([
        //    "countries" => $countries
        //], 200);

        return response()->json([
            "countries" => CountryCollection::collection($countries)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            "name" => ["required"],
            "image" => ["image", "max:5000"]
        ]);

        $country = Country::create($data);

        if($request->hasFile("image") && $request->file("image")->isValid()) {
            $image = $request->file("image");
            $newImage = "country " . mt_rand(1, 100) . " " . $image->getClientOriginalName();
            $image->storeAs("images/country", $newImage, "public");
            $country->image = $newImage; 
        }
        $country->save();

        return response()->json([
            "country_stored" => new CountryResource($country)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //return response()->json([
        //    "country" => $country
        //], 200);

        return response()->json([
            "country" => new CountryResource($country)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $data = $this->validate($request, [
            "name" => ["required"],
            "image" => ["image", "max:5000"]
        ]);

        $country->name = $request->name;
        $country->update();
    
        if($request->hasFile("image") && $request->file("image")->isValid()) {
            //dd('/public/images/country/' . $country->image);
            if($country->image) {
                Storage::delete('/public/images/country/' . $country->image);
            }
            $image = $request->file("image");
            $newImage = "country " . mt_rand(101, 500) . " " . $image->getClientOriginalName();
            $image->storeAs("images/country", $newImage, "public");
            $country->image = $newImage; 
        }
        $country->update();

        return response()->json([
            "country_updated" => new CountryResource($country)
        ], 205);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if($country->image) {
            Storage::delete("/public/images/country/" . $country->image);
        }

        $country->delete();

        return response()->json([
            "country" => $country,
            "Action" => "DELETED"
        ]);
    }

    public function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        Country::truncate();

        return response()->json([
            "Action" => "Country TRUNCATED"
        ]);
    }
}
