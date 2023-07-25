<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Serie::all();
        return response()->json($series);
    }

    public function show(string $id)
    {
        $serie = Serie::find($id);
        return response()->json($serie);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $serie = Serie::create($request->all());

        return response()->json($serie, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $serie = Serie::findOrFail($id);
        $serie->update($request->all());

        return response()->json($serie);
    }

    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();

        return response()->json(null, 204);
    }

    public function serieRandom($cantidad){
        $series = Serie::inRandomOrder()->limit($cantidad)->get();
        return response()->json([
            "series" => $series
        ]);
    }
    function seriesByCategory($category)
    {
        $series = Serie::where("category_id", $category)
                    ->orderBy("name", "ASC")
                    ->get();

        return response()->json($series);
    }
}
