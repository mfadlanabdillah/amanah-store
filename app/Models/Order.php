<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PaymentMethod;
use App\Models\OrderProduct;

class Order extends Model
{
    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone',
        'date_of_birth',
        'total_price',
        'note',
        'payment_method_id',
        'paid_amount',
        'change_amount'
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
