<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCollectionResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all(); // Барлық категорияларды аламыз

        return response()->json([
            'products' => ProductCollectionResource::collection($products),
            'categories' => $categories
        ]);
    }
}
