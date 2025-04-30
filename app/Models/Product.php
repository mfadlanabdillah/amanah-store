<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use App\Models\ProductModel;
use App\Models\Brand;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'stock',
        'price',
        'is_active',
        'image',
        'barcode',
        'brand_id',
        'product_model_id',
        'category_id',
        'imei1',
        'imei2',
        'color',
        'condition',
        'storage_capacity',
        'screen_size',
        'processor',
        'ram',
        'battery_capacity',
        'additional_specs',
        'description'
    ];
    public function productModel(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
