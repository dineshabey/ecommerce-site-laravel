@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Products</h2>
    <div class="row">
        @foreach ($allProducts as $products)
        <div class="col-4">
        <div class="card">
            <img class="card-img-top" src="{{asset('images/car.jpg')}}" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title">{{$products->product_name}}</h4>
                    <p class="card-text">{{$products->description}}</p>
                    <h4 class="card-text">${{$products->price}}</h4>
                </div>
                <div class="card-body">
                <a href="{{route('cart.add',$products->id)}}" class="card-link">Add to cart</a>
                </div>
            </div>
        </div>
        @endforeach
       
    </div>
</div>
@endsection
