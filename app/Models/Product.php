<?php

namespace App\Models;

use App\Models\Relations\ProductRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, ProductRelations;

    protected $fillable = ['title', 'poster', 'price', 'old_price', 'category_id', 'active'];

    protected $table = 'products';

}
