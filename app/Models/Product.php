<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected $fillable = [
     'name',
     'price',
     'sku',
     'barcode',
     'category_id',
     'company_id',
    ];
}
