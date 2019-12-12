<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\apiController;

use App\Http\Controllers\Controller;

class BuyerSellerController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
       $seller = $buyer->transactions()->with('product.seller')->get()->pluck('product.seller')
       ->unique('id')
       ->values();
        return $this->showAll($seller);
    }


}
