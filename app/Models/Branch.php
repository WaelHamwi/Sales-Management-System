<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function orders()
   {
       return $this->hasMany(Order::class);
   }
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
    public function company()
  {
      return $this->belongsTo(Company::class);
  }
    protected $fillable = [
     'name',
     'company_id'
    ];
}
