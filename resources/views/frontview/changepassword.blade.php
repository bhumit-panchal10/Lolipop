@extends('layouts.front')
@section('title', 'Change Password')
@section('content')
    @include('common.front.frontalert')
    <!-- Start Contact -->
    <section id="contact-us" class="contact-us section">
        <div class="container">
            <div class="contact-head">
                <div class="profile-container  row">
                    <div class="col-lg-3">
                        <ul class="left">
                            <li>
                                <a href="{{ route('myaccount') }}">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('myorders') }}">My Order</a>
                            </li>
                            <li>
                                <a href="{{ route('mywishlist') }}">My Wishlist</a>
                            </li>
                            <li>
                                <a class="active" href="{{ route('changepassword') }}">change Password</a>
                            </li>
                            <li>
                                <a href="{{ route('FrontIndex') }}">Shop</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="form-main">
                            <div class="title">
                                <h4>Change Password</h4>
                                <!-- <h3>Write us a message</h3> -->
                            </div>
                            <form class="form" method="post" action="{{ route('changepasswordsubmit') }}">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <label>New Password<span>*</span></label>
                                            <input name="newpassword" type="password" placeholder="" required
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <label>Confirm Password<span>*</span></label>
                                            <input name="confirmpassword" type="password" placeholder="" required
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="submit" class="btn ">Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--/ End Contact -->



@endsection
