<?php

namespace App\Http\Controllers;

use App\River;
use App\CountryBlog;
use Illuminate\Http\Request;
use App\Http\Resources\RiverCollection;
use App\Http\Resources\RiverResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryBlog $countryBlog)
    {
        $rivers = River::paginate(5);

        return response()->json([
            "rivers" => RiverCollection::collection($rivers)
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CountryBlog $countryBlog)
    {
        $this->validate($request, [
            "name" => ["required"],
            "length" => ["required"],
            "size" => ["required"],
            "coordinates" => ["required"],
            "description" => ["required"],
            "image1" => ["image", "max:5000"],
            "image2" => ["image", "max:5000"],
            "image3" => ["image", "max:5000"]
        ]);

        $river = new River();
        $river->name = $request->name;
        $river->length = $request->length;
        $river->size = $request->size;
        $river->coordinates = $request->coordinates;
        $river->description = $request->description;
        
        if($request->hasFile("image1") && $request->file("image1")->isValid()) {
            $image1 = $request->file("image1");
            $newImage1 = mt_rand(1, 100) . $image1->getClientOriginalName();
            $image1->storeAs("images/river/", $newImage1, "public");
            $river->image1 = $newImage1;
        }

        if($request->hasFile("image2") && $request->file("image2")->isValid()) {
            $image2 = $request->file("image2");
            $newImage2 = mt_rand(1, 100) . $image2->getClientOriginalName();
            $image2->storeAs("images/river/", $newImage2, "public");
            $river->image2 = $newImage2;
        }

        if($request->hasFile("image3") && $request->file("image3")->isValid()) {
            $image3 = $request->file("image3");
            $newImage3 = mt_rand(1, 100) . $image3->getClientOriginalName();
            $image3->storeAs("images/river/", $newImage3, "public");
            $river->image3 = $newImage3;
        }
        $countryBlog->rivers()->save($river);

        return response()->json([
            "river" => new RiverResource($river)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\River  $river
     * @return \Illuminate\Http\Response
     */
    public function show(CountryBlog $countryBlog, River $river)
    {
        return response()->json([
            "river" => new RiverResource($river)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\River  $river
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CountryBlog $countryBlog, River $river)
    {
        $this->validate($request, [
            "name" => ["required"],
            "length" => ["required"],
            "size" => ["required"],
            "coordinates" => ["required"],
            "description" => ["required"],
            "image1" => ["image", "max:5000"],
            "image2" => ["image", "max:5000"],
            "image3" => ["image", "max:5000"]
        ]);

        //$river = new River();
        $river->name = $request->name;
        $river->length = $request->length;
        $river->size = $request->size;
        $river->coordinates = $request->coordinates;
        $river->description = $request->description;
        $river->update();
        
        if($request->hasFile("image1") && $request->file("image1")->isValid()) {
            if($river->image1) {
                Storage::delete("/public/images/river/" . $river->image1);
            }
            $image1 = $request->file("image1");
            $newImage1 = mt_rand(101, 500) . $image1->getClientOriginalName();
            $image1->storeAs("images/river/", $newImage1, "public");
            $river->image1 = $newImage1;
        }

        if($request->hasFile("image2") && $request->file("image2")->isValid()) {
            if($river->image2) {
                Storage::delete("/public/images/river/" . $river->image2);
            }
            $image2 = $request->file("image2");
            $newImage2 = mt_rand(101, 500) . $image2->getClientOriginalName();
            $image2->storeAs("images/river/", $newImage2, "public");
            $river->image2 = $newImage2;
        }

        if($request->hasFile("image3") && $request->file("image3")->isValid()) {
            if($river->image3) {
                Storage::delete("/public/images/river/" . $river->image3);
            }
            $image3 = $request->file("image3");
            $newImage3 = mt_rand(101, 500) . $image3->getClientOriginalName();
            $image3->storeAs("images/river/", $newImage3, "public");
            $river->image3 = $newImage3;
        }
        //$countryBlog->rivers()->save($river);
        $river->update();

        return response()->json([
            "river" => new RiverResource($river)
        ], Response::HTTP_RESET_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\River  $river
     * @return \Illuminate\Http\Response
     */
    public function destroy(CountryBLog $countryBlog, River $river)
    {
        if($river->image1)  {
            Storage::delete("/public/images/river/" . $river->image1);
        }

        if($river->image2)  {
            Storage::delete("/public/images/river/" . $river->image2);
        }

        if($river->image3)  {
            Storage::delete("/public/images/river/" . $river->image3);
        }

        $river->delete();

        return response()->json([
            "river" => new RiverResource($river),
            "Action" => "DELETED"
        ], Response::HTTP_NOT_FOUND);
    }

    public function allRivers() {
        $rivers = River::get();

        return response()->json([
            "rivers" => RiverCollection::collection($rivers)
        ], Response::HTTP_OK);
    }

    public function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        River::truncate();

        return response()->json([
            "Action" => "River TRUNCATED"
        ], Response::HTTP_NOT_FOUND);
    }
}
