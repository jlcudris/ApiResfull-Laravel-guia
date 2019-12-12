<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\apiController;
use App\Buyer;

class BuyerController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $compradores = Buyer::has('transactions')->get();

        //return response()->json(['comprador'=>$compradores],200);

        //hacemos el uso del traits que hemos intancaido en apicontroller
        return $this->showAll($compradores);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //utilizando Global Scope
    public function show(Buyer $buyer)
    {
        //con esto devolvemos las transacciones del usuario mas no los dato del usuario
        // $compradoress = Buyer::findOrFail($id)->transactions;

        //aqui accederemos al comprador con id que tenga una transaccion y al final lo que haremos es utilzar el metodo
        //findOrFail

        // $Compradores =Buyer::has('transactions')->findOrFail($id);

        // return response()->json(['comprador'=>$Compradores],200);

        return $this->showOne($buyer);
    }
}
