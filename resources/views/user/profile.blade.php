	@extends('layouts.master')

@section('title')
Laravel Shopping Cart

@endsection

@section('content')
	<div class="row">
		<div class=" col-md-8 col-md-offset-2">
			<h1>User Profile</h1>		
			<hr>
			<h2>My Order</h2>
			@foreach($orders as $order)
			<div class="panel panel-default">
			  <div class="panel-body">
			    <ul class="list-group">
					@foreach($order->cart->items as $item)	
					
				  		<li class="list-group-item">
				  			<span class="badge">${{number_format($item['price']/100,2)}}</span>
				  			{{$item['item']['title']}} | {{$item['qty']}} Units
				  		</li>
				  	@endforeach
				</ul>
			  </div>
			  <div class="panel-footer">Total Price ${{number_format($order->cart->totalPrice/100,2)}}</div>
			</div>
			@endforeach
	  	</div>
	</div>
@endsection