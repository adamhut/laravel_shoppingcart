<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    //
    public function index()
    {
    	$customers = Customer::all();
    	return view('customers.index',compact('customers'));
    }


    public function getData(Request $request)
    {
    	
    	$columns = Customer::$columns;
    	$operators = Customer::$operators;

    	$v = Validator::make($request->only([
    		'column','direction','per_page',
    		'search_column','search_operator','search_input'
    	]),[
    		'column' => 'required|alpha_dash|in:'.implode(',', $columns),
    		'direction' => 'required|in:asc,desc',
    		'per_page' => 'required|integer|min:1',
    		'search_column'=> 'required|alpha_dash|in:'.implode(',', $columns),
    		'search_operator'=> 'required|alpha_dash|in:'.implode(',', array_keys($operators)),
    		'search_input'=> 'max:255',
    	]);

    	if($v->fails()){
    		dd($v->messages());
    	}

    	$model = Customer::SearchPaginateAndOrder();		

    	return response()->json([
    			'model' => $model,
    			'columns' => $columns,
    			'operators' => $operators,
    		]);
    }
}
