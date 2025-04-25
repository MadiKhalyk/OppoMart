<?php

namespace App\Http\Controllers\API;

use App\Enum\PurchaseStatus;
use App\Enum\WhatsappMessageButton;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Services\Whatsapp\WhatsappService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required',
            'total_price' => 'required',
            'address' => 'nullable|string',
            'products' => 'required|array',
            'products.*' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required',
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
            $text .= "{$product->title}: {$product->price} x {$item['quantity']}шт\n";
        }

        $text .= "\nИтого: {$totalPrice}\n";

        $purchase = Purchase::query()
            ->create([
                'user_id' => $user->id,
                'total_price' => $validated['total_price'] ?? $totalPrice,
                'address' => $validated['address'] ?? null,
                'status' => PurchaseStatus::NEW->value
            ]);

        foreach ($validated['products'] as $item) {
            $product = Product::find($item['product_id']);
            $purchase->products()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['quantity'] * $product->price,
            ]);
        }

        $whatsappService = new WhatsappService();
        $whatsappService->sendMessage(
            phoneNumberId: $user->whatsappChat?->phone_number_id,
            body: [
                'phone' => $phone,
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
}
