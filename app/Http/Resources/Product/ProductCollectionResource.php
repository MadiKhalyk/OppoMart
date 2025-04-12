<?php

namespace App\Http\Resources\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'poster' => $this->poster,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'category' =>$this->category,
        ];
    }
}
