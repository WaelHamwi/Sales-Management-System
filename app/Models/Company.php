<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
    public function categories()
   {
       return $this->hasMany(Category::class);
   }
   public function products()
  {
      return $this->hasMany(Product::class);
  }
  public function currency()
  {
      return $this->hasOne(Currency::class, 'id', 'currency_id');
  }
    protected $fillable = [
     'name',
     'currency_id', 
    ];
}
