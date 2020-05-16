<?php

namespace App\Http\Controllers;

use App\Number;
use App\Citizen;
use Illuminate\Http\Request;
use App\Http\Resources\NumberCollection;
use App\Http\Resources\NumberResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Citizen $citizen)
    {
        $numbers = Number::paginate(10);

        return response()->json([
            "numbers" => NumberCollection::collection($numbers)
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
            //"citizen_id" => ["required"],
            "number" => ["required"],
            "status" => ["required"]
        ]);

        $number = new Number();
        $number->number = $request->number;
        $number->status = $request->status;
        $citizen->numbers()->save($number);

        return response()->json([
            "number" => new NumberResource($number)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function show(Citizen $citizen, Number $number)
    {
        return response()->json([
            "number" => new NumberResource($number)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citizen $citizen, Number $number)
    {
        $this->validate($request, [
            //"citizen_id" => ["required"],
            "number" => ["required"],
            "status" => ["required"]
        ]);

        $number->number = $request->number;
        $number->status = $request->status;
        $number->update();

        return response()->json([
            "number" => new NumberResource($number)
        ], Response::HTTP_RESET_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citizen $citizen, Number $number)
    {
        $number->delete();

        return response()->json([
            "number" => new NumberResource($number),
            "Action" => "DELETED"
        ], Response::HTTP_NOT_FOUND);
    }

    public function allNumbers() {
        $numbers = Number::paginate(10);

        return response()->json([
            "numbers" => NumberCollection::collection($numbers)
        ], Response::HTTP_OK);
    }

    public function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        Number::truncate();

        return response()->json([
            "Action" => "Numbers TRUNCATED"
        ], Response::HTTP_NOT_FOUND);
    }
}
