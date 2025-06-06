<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->query('per_page', 10);

        $products = Product::paginate($perPage);

        return response()->json($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json($product, Response::HTTP_CREATED);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }
}
