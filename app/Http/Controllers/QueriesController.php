<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QueriesController extends Controller
{
    public function get(){
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function getById(int $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], Response::HTTP_NOT_FOUND);
        } 
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function getNames(){
        $names = Product::select("name")
        ->orderBy("name")
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $names
        ]);
    }


    public function searchName(string $name, float $price){
        $products = Product::where('name', $name)
            ->where('price', '>', $price)
            ->orderBy("name")
            ->select("name", "description")
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function searchString(string $value){
        $products = Product::where('description', 'like', "%{$value}%")
        ->orWhere('name', 'like', "%{$value}%")
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function advanceSearch(Request $request){
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        $products = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function join(){
        $products = Product::join('category', 'product.category_id', '=', 'category.id')
            ->select('product.*', 'category.name as category_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function GroupBy() {
        $products = Product::join('category', 'product.category_id', '=', 'category.id')
            ->select(
                'category.id',
                'category.name as category_name',
                DB::raw('COUNT(product.id) as total')
            )
            ->groupBy('category.id', 'category.name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

}
