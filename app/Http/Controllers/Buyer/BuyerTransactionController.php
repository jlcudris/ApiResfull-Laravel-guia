<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\apiController;


class BuyerTransactionController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $transaction =$buyer->transactions;

        // return response()->json($transaction);

        return $this->showAll($transaction);

    }

   }
