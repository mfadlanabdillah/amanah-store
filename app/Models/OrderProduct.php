<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\OrderProductObserver;

#[ObservedBy(OrderProductObserver::class)]
class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
