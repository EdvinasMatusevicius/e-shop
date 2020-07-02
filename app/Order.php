<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'customer_title',
        'customer_email',
        'customer_phone',
        'customer_address',

    ];
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
