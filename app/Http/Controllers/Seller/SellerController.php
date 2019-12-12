<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\apiController;
use App\Seller;

class SellerController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores =Seller::has('products')->get();

        //return response()->json(['vendedores'=>$vendedores],200);

        return $this->showAll($vendedores);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //$vendedores =Seller::has('products')->findOrFail($id);

        // return response()->json(['vendedores'=>$vendedores],200);

        return $this->showOne($seller);

    }


}
