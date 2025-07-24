<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'product_category_id',
        'product_color_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
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
