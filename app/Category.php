<?php

namespace App;
use App\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates =['delete_at'];
     protected $fillable=['name','description','created_at'];


     public function products(){

        return $this->belongsToMany(Product::class);
     }
}
