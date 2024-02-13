<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function category(){
        return $this->belongsTo(Categories::class,'id_category');
    }
    public function images(){
        if($this->images){
            return url($this->images);
        }else{
            return 'http://placehold.it/250x350';
        }
    }
    public function special(){
        return $this->hasMany(ProductDiscount::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function chart(){
        return $this->hasMany(UserChart::class);
    }
    public function orderDetail(){
        return $this->hasMany(TransactionDetail::class);
    }
}
