<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\apiController;
use App\Transaction;



class TransactionCategoryController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $categories = $transaction->product->categories;

        //return $this->showOne($categories);

        return $this->showAll($categories);
    }


}
