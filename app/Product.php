<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\Category;
use App\Seller;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $dates=['deleted_at'];

    protected $fillable=['name','description','quantity','status','image','seller_id'];


    public function estaDisponible(){

        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    //varios Productos pertenecen a un vendedor (belongsTo =muchos a uno )
    public function seller(){

        return $this->belongsTo(Seller::class);
     }
//muchos a muchos
    public function categories(){

        return $this->belongsToMany(Category::class);
     }

     //un producto puede tener muchas transacciones por eso trasaction es quien lleva la clave foranea
     public function transactions(){

        return $this->hasMany(Transaction::class);
    }


}


