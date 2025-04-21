<?php

namespace App\Http\Controllers\API;

use App\Enum\WhatsappMessageButton;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCollectionResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Services\Whatsapp\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all(); // Барлық категорияларды аламыз

        return response()->json([
            'products' => ProductCollectionResource::collection($products),
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
