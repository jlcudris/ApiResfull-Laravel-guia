<?php

namespace App;
use App\Product;



class Seller extends User

{
    //un vendedor puede vender mucho productos
    public function products(){

        return $this->hasMany(Product::class);
    }
}
