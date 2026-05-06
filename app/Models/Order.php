<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{
    // You MUST add 'phone' and 'address' here so Laravel allows them to be saved
    protected $fillable = [
        'customer_name', 
        'phone', 
        'address', 
        'total_amount', 
        'status'
    ];

    public function items() 
    {
        return $this->hasMany(OrderItem::class);
    }
}