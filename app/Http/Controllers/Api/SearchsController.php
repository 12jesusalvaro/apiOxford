<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchsController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            "keyword" => "required|max:500"
        ]);

        // Buscar los items para el keyword
        $query = Product::query();
        $columns = ['name', 'isbn', 'isbn2'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'LIKE', '%' . $request->keyword . '%');
        }

        $products = $query->paginate(25);

        return response()->json($products);
    }

    public function show($keyword)
    {
        // Buscar los items para el keyword
        $query = Product::query();
        $columns = ['name', 'isbn', 'isbn2'];
        foreach ($columns as $column) {
            $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
        }

        $products = $query->paginate(10);

        return response()->json($products);
    }
}
