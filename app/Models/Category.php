<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    public function product(){
      return $this->hasMany(Product::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected $fillable = [
     'name',
     'company_id',
    ];
}