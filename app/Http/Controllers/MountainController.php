<?php

namespace App\Http\Controllers;

use App\Mountain;
use App\CountryBlog;
use Illuminate\Http\Request;
use App\Http\Resources\MountainCollection;
use App\Http\Resources\MountainResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MountainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryBlog $countryBlog)
    {
        $mountains = Mountain::paginate(5);

        return response()->json([
            "mountains" => MountainCollection::collection($mountains)
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
            "description" => ["required"],
            "elevation" => ["required"],
            "promience" => ["required"],
            "coordination" => ["required"],
            "isolation" => ["required"],
            "image1" => ["image", "max:5000"],
            "image2" => ["image", "max:5000"],
            "image3" => ["image", "max:5000"]
        ]);

        $mountain = new Mountain();
        $mountain->name = $request->name;
        $mountain->elevation = $request->elevation;
        $mountain->promience = $request->promience;
        $mountain->coordination = $request->coordination;
        $mountain->isolation = $request->isolation;
        $mountain->description = $request->description;

        if($request->hasFile("image1") && $request->file("image1")->isValid()) {
            if($mountain->image1) {
                Storage::delete("/public/images/mountain/" . $mountain->image1);
            }
            $image1 = $request->file("image1");
            $newImage1 = "mountain " . mt_rand(1, 100) . " " . $image1->getClientOriginalName();
            $image1->storeAs("images/mountain", $newImage1, "public");
            $mountain->image1 = $newImage1;
        }

        if($request->hasFile("image2") && $request->file("image2")->isValid()) {
            if($mountain->image2) {
                Storage::delete("/public/images/mountain/" . $mountain->image2);
            }
            $image2 = $request->file("image2");
            $newImage2 = "mountain " . mt_rand(1, 100) . " " . $image2->getClientOriginalName();
            $image2->storeAs("images/mountain", $newImage2, "public");
            $mountain->image2 = $newImage2;
        }

        if($request->hasFile("image3") && $request->file("image3")->isValid()) {
            if($mountain->image3) {
                Storage::delete("/public/images/mountain/" . $mountain->image3);
            }
            $image3 = $request->file("image3");
            $newImage3 = "mountain " . mt_rand(1, 100) . " " . $image3->getClientOriginalName();
            $image3->storeAs("images/mountain", $newImage3, "public");
            $mountain->image3 = $newImage3;
        }
        $countryBlog->mountains()->save($mountain);

        return response()->json([
            "mountain" => new MountainResource($mountain)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mountain  $mountain
     * @return \Illuminate\Http\Response
     */
    public function show(CountryBlog $countryBlog, Mountain $mountain)
    {
        return response()->json([
            "mountain" => new MountainResource($mountain)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mountain  $mountain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CountryBlog $countryBlog, Mountain $mountain)
    {
        $this->validate($request, [
            "name" => ["required"],
            "description" => ["required"],
            "elevation" => ["required"],
            "promience" => ["required"],
            "coordination" => ["required"],
            "isolation" => ["required"],
            "image1" => ["image", "max:5000"],
            "image2" => ["image", "max:5000"],
            "image3" => ["image", "max:5000"]
        ]);

        //$mountain = new Mountain();
        $mountain->name = $request->name;
        $mountain->elevation = $request->elevation;
        $mountain->promience = $request->promience;
        $mountain->coordination = $request->coordination;
        $mountain->isolation = $request->isolation;
        $mountain->description = $request->description;
        $mountain->update();

        if($request->hasFile("image1") && $request->file("image1")->isValid()) {
            $image1 = $request->file("image1");
            $newImage1 = "mountain " . mt_rand(1, 100) . " " . $image1->getClientOriginalName();
            $image1->storeAs("images/mountain", $newImage1, "public");
            $mountain->image1 = $newImage1;
        }

        if($request->hasFile("image2") && $request->file("image2")->isValid()) {
            $image2 = $request->file("image2");
            $newImage2 = "mountain " . mt_rand(1, 100) . " " . $image2->getClientOriginalName();
            $image2->storeAs("images/mountain", $newImage2, "public");
            $mountain->image2 = $newImage2;
        }

        if($request->hasFile("image3") && $request->file("image3")->isValid()) {
            $image3 = $request->file("image3");
            $newImage3 = "mountain " . mt_rand(1, 100) . " " . $image3->getClientOriginalName();
            $image3->storeAs("images/mountain/", $newImage3, "public");
            $mountain->image3 = $newImage3;
        }
        //$countryBlog->mountains()->save($mountain);
        $mountain->update();

        return response()->json([
            "mountain" => new MountainResource($mountain)
        ], Response::HTTP_RESET_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mountain  $mountain
     * @return \Illuminate\Http\Response
     */
    public function destroy(CountryBlog $countryBlog, Mountain $mountain)
    {
        $mountain->delete();

        return response()->json([
            "mountain" => new MountainResource($mountain),
            "Action" => "DELETED"
        ], Response::HTTP_NOT_FOUND);
    }

    public function allMountains() {
        $mountains = Mountain::paginate(5);

        return response()->json([
            "mountains" => MountainCollection::collection($mountains)
        ], Response::HTTP_OK);
    }

    public function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        Mountain::truncate();

        return response()->json([
            "Action" => "Mountain TRUNCATED"
        ], Response::HTTP_NOT_FOUND);
    }
}
