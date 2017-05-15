<?php

use App\Customer;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  User::truncate();
        Customer::truncate();
       
      	factory('App\Customer',50)->create(); 
    }

}
