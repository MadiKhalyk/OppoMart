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
        $validated = $request->validate([
            'phone' => 'required|exists:users,phone',
            'products' => 'required|array',
            'products.*' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer'
        ]);

        $phone = $validated['phone'];
        $user = User::query()
            ->where('phone', $phone)
            ->first();

        $totalPrice = 0;
        $text = '';
        foreach ($validated['products'] as $item) {
            $product = Product::find($item['product_id']);
            $totalPrice += $product->price * $item['quantity'];
            $text .= "{$product->title}: {$product->price} x {$item->quantity}\n";
        }

        $text .= "\nИтого: {$totalPrice}\n";

        $purchase = Purchase::query()
            ->create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
            ]);

        $purchase->products()->attach($validated['products'], ['quantity' => $validated['products']]);

        $whatsappService = new WhatsappService();
        $whatsappService->sendMessage(
            phoneNumberId: $user->whatsappChat?->phone_number_id,
            body: [
                'phone' => $validated['phone'],
                'type' => 'interactive',
                'interactive' => [
                    "type" => "button",
                    "header" => [
                        'type' => 'text',
                        'text' => 'Подтверждайте заказ!',
                    ],
                    "body" => [
                        "text" => $text
                    ],
                    "action" => [
                        "buttons" => [
                            [
                                "type" => "reply",
                                "reply" => [
                                    "id" => WhatsappMessageButton::CONFIRM->value,
                                    "title" => "Подтверждаю"
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        );
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
