<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'external_url',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function types()
    {
        // add custom pivot table and additional field to assignments
        return $this->morphToMany(
            ProductType::class,
            'type_assignments',
            'type_assignments', // custom pivot table
            'type_assignments_id',      // morph ID column
            'type_id'                   // product_types.id
        )->withPivot('my_bonus_field');
    }



}
