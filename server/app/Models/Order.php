<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function totalPrice(): float
    {
        $totalPrice = 0.0;

        foreach($this->orderProduct as $orderProduct) {
            $totalPrice += $orderProduct->product_quantity * $orderProduct->product->price;
        }

        return round($totalPrice, 2);
    }

    public function isNew(): bool
    {
        return UserStatus::NEW === $this->status;
    }
}
