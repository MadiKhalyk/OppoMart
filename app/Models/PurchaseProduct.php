<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseProduct extends Model
{
    protected $guarded = ['id'];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
