<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function product()
       {
           return $this->belongsTo(Product::class);
       }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    protected $fillable=[
      'subtotal',
      'product_id',
      'product_price',
      'product_name',
      'order_id',
      'branch_name',
      'currency_symbol',
      'quantity'
    ];
}
