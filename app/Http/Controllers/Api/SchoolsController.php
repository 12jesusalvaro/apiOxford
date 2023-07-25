<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\School;
use App\Models\SchoolLevel;
use App\Models\Country;


class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::paginate(20);
        return response()->json($schools);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $school = School::find($id);
        return response()->json($school);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function schoolsByCountry($country_id)
    {
        $schools = School::where("country_id", $country_id)
        ->orderBy("name", "ASC")
        ->get();

        return response()->json($schools);
    }

    public function schoolsLevels(){

        $schoolslevels = SchoolLevel::paginate(20);
        return response()->json($schoolslevels);
    }
}
