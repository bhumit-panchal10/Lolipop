@extends('layouts.front')
@section('title', 'Profile')
@section('content')
    <section class="sec-padcn edit-bg-img">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-10">
                    <div class="row align-items-center justify-content-center">

                        <div class="col-lg-8 fm-shd bg-white">
                            <div class="cn-pdt">
                                <div>
                                    <p class="text-center sin">EDIT PROFILE</p>
                                </div>

                                <div class="cn-dt">
                                    <div><span class="lnr lnr-user usr"></span><input type="text"
                                            placeholder="Enter Your Name"></div>
                                    <div><span class="lnr lnr-envelope mail2"></span><input type="text"
                                            placeholder="Email"></div>
                                    <div><span class="lnr lnr-phone phn"></span><input type="tel"
                                            placeholder="Enter Your Mobile Number"></div>
                                    <div><span class="lnr lnr-lock ps2-cion"></span>
                                        <input type="password" placeholder="Enter your Password" id="sfpassword">
                                        <img id="signpass" class="signpass" onclick="pass()" width="20"
                                            src="images/icons/hide.png" alt="">
                                    </div>
                                    <div><span class="lnr lnr-lock pscn2-cion"></span>
                                        <input type="password" placeholder="Confirm Password" id="ccpassword">
                                        <img class="signpass2" id="signpass2" onclick="pass2()" width="20"
                                            src="images/icons/hide.png" alt="">
                                    </div>

                                    <div>
                                        <a class="log-bn" href="#"><button>SUBmit</button></a>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
