<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
    'transaction_code',
    'total_price',
    'notes',
    'status',
    'payment_method'
];
    public function details()
{
    return $this->hasMany(OrderDetail::class, 'order_id');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}