<?php

namespace App\Models;

use App\Models\Relations\ComboDiscountRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComboDiscount extends Model
{
    use HasFactory, SoftDeletes, ComboDiscountRelations;

    protected $table = 'combo_discounts';

    protected $guarded = ['id'];


    public function images()
    {
        return $this->hasMany(DiscountImage::class,'discount_id');
    }

}
