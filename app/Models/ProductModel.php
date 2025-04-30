<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'code',
        'description',
        'specifications',
        'is_active'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scope to get active models
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope to get models by brand
    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
}
