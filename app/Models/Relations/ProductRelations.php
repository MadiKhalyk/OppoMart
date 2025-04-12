<?php

namespace App\Models\Relations;

use App\Models\Category;

trait ProductRelations
{
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }
}
