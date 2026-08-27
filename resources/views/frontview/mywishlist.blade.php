@extends('layouts.front')
@section('title', 'My Wishlist')
@section('content')
    @include('common.front.frontalert')

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="profile-container row">
                <div class="col-lg-3">
                    <ul class="left">
                        <li>
                            <a href="{{ route('myaccount') }}">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('myorders') }}">My Order</a>
                        </li>
                        <li>
                            <a class="active" href="{{ route('mywishlist') }}">My Wishlist</a>
                        </li>
                        <li>
                            <a href="{{ route('FrontIndex') }}">Shop</a>
                        </li>


                    </ul>
                </div>
                <div class="col-lg-9">

                    <div class="row ">


                        @foreach ($wishlist as $list)
                            <div class="col-lg-4">
                                <div class="product-grid mb-2">
                                    <div class="product-image">
                                        <a href="#" class="image">
                                            <img class="img-1" src="{{ asset('Product') . '/' . $list->photo }}">
                                        </a>
                                        <ul class="product-links">
                                            <li><a href="{{ route('productdetail', $list->slugname) }}"><i
                                                        class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-content">
                                         <h3 class="title">
                                             <a
                                                href="{{ route('productdetail', $list->slugname) }}">{{ $list->productname }}</a>
                                        </h3>
                                        <div class="price"> ₹ {{ $list->price }}</div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->

@endsection
