<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'total',
        'added_by',
        'customer_id',
        'store_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'cart_order')
                    ->withTimestamps();
    }
    public static function CartSubTotal($customer_id)
    {
        $sum=Cart::where(['customer_id'=> $customer_id,'status'=>'pending'])->sum('total');
        if($sum){
            return $sum;
        }else{
            return 0;
        }
    }
}
