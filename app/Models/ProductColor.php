<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    /** @use HasFactory<\Database\Factories\ProductColorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'hex_code',
        'description'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
