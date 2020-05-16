<?php

namespace App\Http\Controllers;

use App\CountryBlog;
use App\Citizen;
use Illuminate\Http\Request;
use App\Http\Resources\CountryBlogCollection;
use App\Http\Resources\CountryBlogResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CountryBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Citizen $citizen)
    {
        $countryBlogs = CountryBlog::paginate(10);

        return response()->json([
            "country_blogs" => CountryBlogCollection::collection($countryBlogs)
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Citizen $citizen)
    {
        $this->validate($request, [
            "name" => ["required"],
            "population" => ["required"],
            "area_code" => ["required"],
            "description" => ["required"],
            "image" => ["image", "max:5000"]
        ]);

        $countryBlog = new CountryBlog();
        $countryBlog->name = $request->name;
        $countryBlog->population = $request->population;
        $countryBlog->area_code = $request->area_code;
        $countryBlog->description = $request->description;
        if($request->hasFile("image") && $request->file("image")->isValid()) {
            $image = $request->file("image");
            $newImage = "country_blog " . mt_rand(1, 100) . " " . $image->getClientOriginalName();
            $image->storeAs("images", $newImage, "public");
            $countryBlog->image = $newImage;
        }
        $citizen->country_blogs()->save($countryBlog);

        
        //$countryBlog->save();

        return response()->json([
            "country_blog" => new CountryBlogResource($countryBlog)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CountryBlog  $countryBlog
     * @return \Illuminate\Http\Response
     */
    public function show(Citizen $citizen, CountryBlog $countryBlog)
    {
        return response()->json([
            "country_blog" => new CountryBlogResource($countryBlog)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CountryBlog  $countryBlog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citizen $citizen, CountryBlog $countryBlog)
    {
        $this->validate($request, [
            "name" => ["required"],
            "population" => ["required"],
            "area_code" => ["required"],
            "description" => ["required"],
            "image" => ["image", "max:5000"]
        ]);

        //$countryBlog = new CountryBlog();
        $countryBlog->name = $request->name;
        $countryBlog->population = $request->population;
        $countryBlog->area_code = $request->area_code;
        $countryBlog->description = $request->description;
        if($request->hasFile("image") && $request->file("image")->isValid()) {
            $image = $request->file("image");
            $newImage = "country_blog " . mt_rand(1, 100) . " " . $image->getClientOriginalName();
            $image->storeAs("images", $newImage, "public");
            $countryBlog->image = $newImage;
        }
        //$citizen->country_blogs()->save($countryBlog);
        $countryBlog->update();

        
        //$countryBlog->save();

        return response()->json([
            "country_blog" => new CountryBlogResource($countryBlog)
        ], Response::HTTP_RESET_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CountryBlog  $countryBlog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citizen $citizen, CountryBlog $countryBlog)
    {
        $countryBlog->delete();

        return response()->json([
            "country_blog" => new CountryBlogResource($countryBlog),
            "Action" => "DELETED"
        ], Response::HTTP_NOT_FOUND);
    }

    public function allCountryBlogs() {

        $countryBlogs = CountryBlog::paginate(10);

        return response()->json([
            "all_country_blogs" => CountryBlogCollection::collection($countryBlogs)
        ], Response::HTTP_OK);
    }

    public function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        CountryBlog::truncate();

        return response()->json([
            "Action" => "CountryBlogs TRUNCATED"
        ], Response::HTTP_NOT_FOUND);
    }
}
