<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\apiController;
use App\Transaction;



class TransactionSellerController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $sellers = $transaction->product->seller;
        //return response()->json(['data'=>$sellers]);

        // $prueba =Transaction::with(['product', 'buyer'])->get();
        // $prueba =Transaction::with('product')->get();
        //  return response()->json(['data'=>$prueba]);

        return $this->showOne($sellers);

    }


}
