<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'api_unique_number'
    ];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'type_assignments');
    }

    public function categories()
    {
        return $this->morphedByMany(ProductCategory::class, 'type_assignments');
    }
}
