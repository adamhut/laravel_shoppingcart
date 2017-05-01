<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    //
    public function index()
    {
    	$productsRow = Product::all()->chunk(3);
    	return view('shop.index',compact('productsRow'));
    }

    /**
     * 
     */
    public function getAddToCart(Request $request, $id)
    {
    	$product = Product::find($id);

    	$oldCart = Session::has('cart')?Session::get('cart'): null;

    	$cart = new Cart($oldCart);

    	$cart->add($product,$product->id);

    	$request->session()->put('cart',$cart);
    	//dd(Session::get('cart'));
    	return redirect()->route('product.index');


    }

    public function getCart()
    {
    	if(!Session::has('cart'))
    	{
    		$products = null;
    		return view('shop.shopping-cart',compact('products'));
    	}

    	$oldCart =  Session::get('cart') ;
    	$cart = new Cart($oldCart);
    	$products = $cart->items;
    
    	$totalPrice =$cart->totalPrice;
    	return view('shop.shopping-cart',compact('products','totalPrice'));
    }


    public function getCheckout()
    {
        if(!Session::has('cart'))
        {
            $products = null;
            return view('shop.shopping-cart',compact('products'));
        }

        $oldCart =  Session::get('cart') ;
        $cart = new Cart($oldCart);
        $totalPrice =$cart->totalPrice;

        return view('shop.checkout',['total'=>$totalPrice]);

    }

    public function postCheckout(Request $request)
    {
        if(!Session::has('cart'))
        {
            $products = null;
            return redirect()->route('product.shoppingCart');
        }
        $oldCart =  Session::get('cart') ;
        $cart = new Cart($oldCart);
        $totalPrice =$cart->totalPrice;
        $token = $request->input('stripeToken');

        Stripe::setApiKey(config('services.stripe.secret'));
        //Stripe::setApiKey("sk_test_Db5TuDQrJHsOzzEJCChctrfL");

        try{
            Charge::create(array(
              "amount" => $totalPrice,
              "currency" => "usd",
              "source" =>  $token , // obtained with Stripe.js
              "description" => "Charge for test"
            ));
        }catch(\Exception $e)
        {
            return redirect()->route('checkout')->with(['error' =>$e->getMessage()]);
        }

        Session::forget('cart');
        return redirect()->route('product.index')->with(['success'=>'Purchased Successfuly ']);

    }
}
