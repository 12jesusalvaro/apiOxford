<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSchoolLevel;
use App\Models\Serie;
use App\Models\SchoolLevel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* // get series
        $series = Serie::inRandomOrder()->limit(20)->get();

        // get products from 5 diferent series
        $id_series_selected = [9, 4, 5, 8, 7];

        $group_products = [];

        for ($i = 0; $i < count($id_series_selected); $i++) {
            $group_products[$i] = [];

            $group_products[$i]["serie"] = Serie::find($id_series_selected[$i]);

            $group_products[$i]["products"] = Product::join("levels", "products.level_id", "=", "levels.id")
                ->join("series", "levels.serie_id", "=", "series.id")
                ->where("series.id", $id_series_selected[$i])
                ->select("products.*")
                ->get();
        }

        return response()->json([
            "series" => $series,
            "group_products" => $group_products
        ]);*/
        $products = Product::paginate(20);

        return response()->json($products);
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
        $product = Product::find($id);
        return response()->json($product);
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

    public function productsByseries(Request $request, $idseries){
 /*
        $ids = $request->input('ids', []);

        // Validar si se proporcionaron los IDs
        if (empty($ids)) {
            return response()->json(['message' => 'No se proporcionaron IDs'], 400);
        }

        // Obtener los productos correspondientes a los IDs
        $products = Product::whereIn('id', $ids)->get();

        // Verificar si se encontraron productos
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos para los IDs proporcionados'], 404);
        }

        // Retornar los productos como respuesta
        return response()->json($products, 200);
*/
        //$id_series_selected = $request->input('ids', []);
        $id_series_selected = explode(',', $idseries);
        $group_products = [];

        /*for ($i = 0; $i < count($id_series_selected); $i++) {
            $group_products[$i] = [];

            $group_products[$i]["serie"] = Serie::find($id_series_selected[$i]);

            $group_products[$i]["products"] = Product::join("levels", "products.level_id", "=", "levels.id")
                ->join("series", "levels.serie_id", "=", "series.id")
                ->where("series.id", $id_series_selected[$i])
                ->select("products.*")
                ->get();


            //$group_products[$i] = Product::whereIn('id', $id_series_selected)->get();
        }*/
        for ($i=0; $i < count($id_series_selected); $i++) {
            $group_products[$i] = Product::join('levels', 'products.level_id', '=', 'levels.id')
                    ->join('series', 'levels.serie_id', '=', 'series.id')
                    ->where('series.id', $id_series_selected[$i])
                    ->select('products.*')
                    ->get();
        }
        return response()->json([
            $group_products
        ]);
    }

    public function productsBySerie($serie_id)
    {
        $group_products = Product::join('levels', 'products.level_id', '=', 'levels.id')
                    ->join('series', 'levels.serie_id', '=', 'series.id')
                    ->where('series.id', $serie_id)
                    ->select('products.*')
                    ->get();

        return response()->json($group_products);
    }

    public function productsByLevel($level_id){
        $productos = Product::where("level_id", $level_id)
        ->orderBy("name", "ASC")
        ->get();

        return response()->json($productos);
    }

    public function productsBySchoolLevel($schoolLevelId)
    {
        $products = ProductSchoolLevel::join("products", "product_school_level.product_id", "=", "products.id")
            ->where("product_school_level.school_level_id", $schoolLevelId)
            ->orderBy("products.name", "ASC")
            ->select("products.*")
            ->get();

        return response()->json($products);
    }
}
