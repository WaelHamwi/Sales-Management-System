<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function branch()
  {
      return $this->belongsTo(Branch::class);
  }
  public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected $fillable=[
      'date',
      'price',
      'branch_id',
      'status'
    ];
}
