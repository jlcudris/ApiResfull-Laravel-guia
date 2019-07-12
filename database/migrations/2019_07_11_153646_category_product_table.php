<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {

            //se borra el id ya que solo necesitamos las instancias de los modelos de la tabla pivote
               //FK user instancia de Product
               $table->unsignedBigInteger('product_id')->index();
               $table->foreign('product_id')->references('id')->on('products');

                //FK user instancia de categories
               $table->unsignedBigInteger('category_id')->index();
               $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
    }
}
