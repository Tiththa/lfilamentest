<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'external_url',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function types(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ProductType::class, 'type_assignments');
    }

}
