<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\apiController;


class BuyerProductController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()->with('product')->get()->pluck('product');

        return $this->showAll($products);
    }


}
