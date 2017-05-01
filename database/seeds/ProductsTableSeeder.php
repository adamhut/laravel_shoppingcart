<?php

use App\User;
use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        Product::truncate();
        factory('App\User')->create([
            'name' =>'adamtest',
            'email' =>'ahuang@bacera.com',
            'password' =>bcrypt('test1234'),
        ]);
      	factory('App\Product',10)->create(); 
    }
}
