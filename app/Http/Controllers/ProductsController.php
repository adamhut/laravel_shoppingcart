<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{

	public function __construct()
	{
		//$this->middleware('auth');
	}


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

    /**
     * 
     */
    public function getReduceByOne($id)
    {
        $product = Product::find($id);

        $oldCart = Session::has('cart')?Session::get('cart'): null;

        $cart = new Cart($oldCart);

        $cart->reduceByOne($id);

        if(count($cart->items)>0)
        {
            Session::put('cart',$cart);
        }else
        {
            Session::forget('cart');
        }  

        //dd(Session::get('cart'));
        return redirect()->route('product.shoppingCart'); //view('shop.shopping-cart',compact('products','totalPrice'));
    }

     /**
     * 
     */
    public function getRemoveItemFromCart($id)
    {
        $product = Product::find($id);

        $oldCart = Session::has('cart')?Session::get('cart'): null;

        $cart = new Cart($oldCart);

        $cart->removeItem($id);

        if(count($cart->items)>0)
        {
            Session::put('cart',$cart);
        }else
        {
            Session::forget('cart');
        }   

        //dd(Session::get('cart'));
        return redirect()->route('product.shoppingCart'); 


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
            $charge = Charge::create(array(
              "amount" => $totalPrice,
              "currency" => "usd",
              "source" =>  $token , // obtained with Stripe.js
              "description" => "Charge for test"
            ));

            Order::create([
            	'user_id'=>auth()->id(),
            	'cart' =>serialize($cart),
            	'address' => request('address'),
            	'name' => request('name'),
            	'payment_id' => $charge->id,
            ])->save();

            //or 
            /*
            $order = new Order;

			$order->cart =serialize($cart);
			$order->address = request('address');
			$order->name = request('name');
			$order->payment_id =$cahrge->id;

			Auth::user()->orders()->save($order);
			*/
        }catch(\Exception $e)
        {
            return redirect()->route('checkout')->with(['error' =>$e->getMessage()]);
        }

        



        Session::forget('cart');
        return redirect()->route('product.index')->with(['success'=>'Purchased Successfuly ']);

    }
}
