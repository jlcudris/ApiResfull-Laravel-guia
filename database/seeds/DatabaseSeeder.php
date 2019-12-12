<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();

        DB::table('category_product')->truncate();

        $cantidaduser=1000;
        $cantidadCategories=30;
        $cantidadProductos=1000;
        $cantidadTransaciones=1000;

        factory(User::class,$cantidaduser)->create();
        factory(Category::class,$cantidadCategories)->create();

        factory(Product::class,$cantidadProductos)->create()->each(function($producto)
        {
            $categorias =Category::all()->random(mt_rand(1,5))->pluck('id');

            $producto->categories()->attach($categorias);


        });

        factory(Transaction::class,$cantidadTransaciones)->create();


    }
}
