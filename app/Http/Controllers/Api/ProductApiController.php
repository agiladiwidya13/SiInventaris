<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $products = Product::query()
            ->when($search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
            })
            ->when($categoryId, function($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->with('category')
            ->get();

        return ProductResource::collection($products);
    }

    

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }
}
