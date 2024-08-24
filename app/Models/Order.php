<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'store_id',
        'total_amount',
        'payment_status',
        'order_status',
        'shipping_address',
        'billing_address',
    ];
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_order')->withTimestamps();
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
