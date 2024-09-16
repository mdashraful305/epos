<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'address',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'store_id');

    }
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}
