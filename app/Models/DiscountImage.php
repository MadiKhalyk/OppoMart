<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountImage extends Model
{
    use HasFactory;

    protected $table = 'discount_images';

    protected $fillable = ['poster', 'discount_id'];


}
