<?php

namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{

//trait para devolver las respusta de la api succes
    private function successResponse($data, $code){

        return response()->json($data,$code);
    }

    protected function errorResponse($message,$code){

        return response()->json(['error'=>$message, 'code'=>$code],$code);
    }

    //esta funcion retornara una coleccion (por ejemplo todo los usuarios)
    protected function showAll(Collection $collection, $code = 200){

        return $this->successResponse(['data'=>$collection],$code);

    }
//esta funcion retornara una instancia de un objeto especifico (por ejemplo un usuario en particular)
    protected function showOne(Model $instance, $code=200){

        return $this->successResponse(['data'=>$instance],$code);
    }

}
