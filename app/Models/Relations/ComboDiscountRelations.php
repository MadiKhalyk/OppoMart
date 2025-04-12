<?php

namespace App\Models\Relations;

use App\Models\DiscountImage;

trait ComboDiscountRelations
{
    public function images()
    {
        return $this->hasMany(DiscountImage::class,'discount_id');
    }

}
