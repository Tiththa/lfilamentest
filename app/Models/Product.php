<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'product_category_id',
        'product_color_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function types()
    {
        return $this->morphMany(ProductType::class, 'type_assignments');
    }

}
