@extends('layouts.front')
@section('title', 'User Profile')
@section('content')

    <section class="shop checkout section">

        <div class="container">
            <div class="profile-container row">
                <div class="col-lg-3">
                    <ul class="left">
                        <li>
                            <a class="active" href="{{ route('myaccount') }}">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('myorders') }}">My Order</a>
                        </li>
                        
                        <li>
                            <a href="{{ route('FrontIndex') }}">Shop</a>
                        </li>

                    </ul>
                </div>
                <div class="col-lg-9">
                    @php
                        $session = Session::get('customername');
                    @endphp

                    <p class="bold usrtitle">Hello, <span class="usrname">{{ $session }}</span></p>

                    <hr><br><br>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="serviceBox">
                                    <div class="service-icon">
                                        <span><i class="fa fa-home"></i></span>
                                    </div>
                                    <h3 class="title"><a href="{{ route('FrontIndex') }}">Home</a></h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="serviceBox purple">
                                    <div class="service-icon">
                                        <span><i class="fa fa-shopping-cart"></i></span>
                                    </div>
                                    <h3 class="title"><a href="{{ route('myorders') }}">Your  Order</a></h3>
                                </div>
                            </div>
                            <!--<div class="col-md-3 col-sm-6">-->
                            <!--    <div class="serviceBox purple">-->
                            <!--        <div class="service-icon">-->
                            <!--            <span><i class="fa fa-history"></i></span>-->
                            <!--        </div>-->
                            <!--        <h3 class="title"><a href="my-order.php"> Your Order History</a></h3>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-3 col-sm-6">-->
                            <!--    <div class="serviceBox purple">-->
                            <!--        <div class="service-icon">-->
                            <!--            <span><i class="fa fa-heart"></i></span>-->
                            <!--        </div>-->
                            <!--        <h3 class="title"><a href="{{ route('mywishlist') }}">Your Wishlist</a></h3>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection
