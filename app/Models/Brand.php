<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\Product;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'is_active'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query): Builder
    {
        return $query->where('is_active', true);
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
