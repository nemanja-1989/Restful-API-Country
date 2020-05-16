<?php

namespace App\Http\Controllers;

use App\Mountain;
use App\CountryBlog;
use Illuminate\Http\Request;
use App\Http\Resources\MountainCollection;
use App\Http\Resources\MountainResource;
use Symfony\Component\HttpFoundation\Response;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mountain  $mountain
     * @return \Illuminate\Http\Response
     */
    public function show(Mountain $mountain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mountain  $mountain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mountain $mountain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mountain  $mountain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mountain $mountain)
    {
        //
    }
}
