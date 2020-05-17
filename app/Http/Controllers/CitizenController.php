<?php

namespace App\Http\Controllers;

use App\Citizen;
use App\Country;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\CitizenCollection;
use App\Http\Resources\CitizenResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country)
    {
        $citizens = $country->citizens;

        return response()->json([
            "citizens" => CitizenCollection::collection($citizens)
        ], Response::HTTP_OK);

        //return $citizens;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Country $country)
    {
        //return $country;    
        $this->validate($request, [
            //"country_id" => ["required"],
            "name" => ["required"],
            "email" => ["required"],
            "password" => ["required"],
            "status" => ["required"],
            "image" => ["image", "max:5000"]
        ]); 
        
        //$citizen = Citizen::create($data);

        $citizen = new Citizen();
        $citizen->name = $request->name;
        $citizen->email = $request->email;
        $citizen->password = bcrypt($request->password);
        $citizen->status = $request->status;
        $country->citizens()->save($citizen);

        if($request->hasFile("image") && $request->file("image")->isValid()) {
            $image = $request->file("image");
            $newImage = "citizen " . mt_rand(1, 100) . " " . $image->getClientOriginalName();
            $image->storeAs("images/citizen/", $newImage, "public");
            $citizen->image = $newImage;
        }
        $citizen->save();

        return response()->json([
            "citizen" => new CitizenResource($citizen)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country, Citizen $citizen)
    {
        return response()->json([
            "citizen" => new CitizenResource($citizen)
        ], Response::HTTP_OK);

        //return $citizen;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country, Citizen $citizen)
    {
        $this->validate($request, [
            //"country_id" => ["required"],
            "name" => ["required"],
            "email" => ["required"],
            "password" => ["required"],
            "status" => ["required"],
            "image" => ["image", "max:5000"]
        ]);

        $citizen->name = $request->name;
        $citizen->email = $request->email;
        $citizen->password = $request->password;
        $citizen->status = $request->status;
        $citizen->update();

        if($request->hasFile("image") && $request->file("image")->isValid()) {
            if($citizen->image) {
                Storage::delete("/public/images/citizen/" . $citizen->image);
            }
            $image = $request->file("image");
            $newImage = "citizen " . mt_rand(101, 500) . " " . $image->getClientOriginalName();
            $image->storeAs("images/citizen/", $newImage, "public");
            $citizen->image = $newImage;
        }
        $citizen->update();

        return response()->json([
            "citizen" => new CitizenResource($citizen)
        ], Response::HTTP_RESET_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country, Citizen $citizen)
    {
        if($citizen->image) {
            Storage::delete("/public/images/citizen/" . $citizen->image);
        }
        
        $citizen->delete();

        return response()->json([
            "citizen" => new CitizenResource($citizen),
            "Action" => "DELETED"
        ], Response::HTTP_NOT_FOUND);
    }

    public function allCitizens() {
        $citizens = Citizen::paginate(5);

        return response()->json([
            "citizens" => CitizenCollection::collection($citizens)
        ], Response::HTTP_OK);
    }

    public function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        Citizen::truncate();

        return response()->json([
            "Action" => "Citizen TRUNCATED"
        ], Response::HTTP_NOT_FOUND);
    }
}
