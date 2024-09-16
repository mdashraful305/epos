<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
        'image',
        'store_id',
        'category_id',
        'supplier_id',
        'price',
        'original_price',
        'discounted_price',
        'stock',
        'sku',
        'status',
        'subcategory_id',
        'unit',
        'discount_type',
        'discount_value',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory that owns the product.
     */
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_id');
    }


}
