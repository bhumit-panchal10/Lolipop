@extends('layouts.front')
@section('title', 'Register')
@section('content')
    <section class="sec-padcn">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-11 col-lg-10">
                    {{--  @include('common.alert')  --}}
                    @include('common.registeralert')
                    <div class="row fm-shd align-items-center ">
                        <div class="col-12 col-md-6 col-lg-6 px-0">
                            <div class="log-img">
                                <img class="img-fluid" src="{{ asset('assets/frontimages/banner/slide-cn.avif') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="cn-pdt">
                                <div>
                                    <p class="text-center sin">SIGN UP</p>
                                </div>

                                <div class="cn-dt">
                                    <form id="myForm" action="{{ route('registerstore') }}" method="post">
                                        @csrf
                                        <div>
                                            <span class="lnr lnr-user usr"></span>
                                            <input type="text" name="customername" placeholder="Enter Your Name"
                                                value="{{ old('customername') }}" required>
                                            @error('customername')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="mail-rel">
                                            <span class="lnr lnr-envelope mail2 mail-reg-icon"></span>
                                            <input type="email" name="customeremail" placeholder="Enter Your Email"
                                                value="{{ old('customeremail') }}" required>
                                            @error('customeremail')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="signup-cl-rel">
                                            <span class="lnr lnr-phone-handset signup-cl-icon"></span>
                                            <input type="text" name="customermobile" maxlength="10" minlength="10"
                                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                value="{{ old('customermobile') }}" placeholder="Enter Your Mobile Number"
                                                required>
                                            @error('customermobile')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="lgn-rel">
                                            <span class="lnr lnr-lock lgn-lockicon"></span>
                                            <input type="password" name="password" placeholder="Enter your Password"
                                                id="password" required>
                                            <img class="lgn-abs" id="lgn-lock-icon" onclick="lgnpassword()" width="20"
                                                src="{{ asset('assets/frontimages/icons/hide.png') }}" alt="">
                                            @error('password')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="lgn-rel">
                                            <span class="lnr lnr-lock lgn-lockicon"></span>
                                            <input type="password" name="confirmpassword" placeholder="Confirm Password"
                                                id="ccpassword" required>
                                            <img class="lgn-abs2" id="lgn-lock-icon2" onclick="lgnpassword2()"
                                                width="20" src="{{ asset('assets/frontimages/icons/hide.png') }}"
                                                alt="">
                                            @error('confirmpassword')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        {{--  <div class="form-group{{ $errors->has('registercaptcha') ? ' has-error' : '' }}">
                                            <div class="form-group mt-4 mb-4">
                                                <div class="captcha">  --}}
                                        {{--  <span> {!! captcha_img() !!} </span>  --}}
                                        {{--  @include('frontview.custom_captcha')  --}}

                                        {{--  <button type="button" class="btn btn-danger" class="reload"
                                                        id="reload">&#x21bb;
                                                    </button>
                                                </div>
                                            </div>
                                            <input id="captcha" type="text" class="form-control" 
                                                placeholder="Enter Captcha" name="registercaptcha" required>

                                            @error('registercaptcha')
                                                <strong class="text-danger">{{ $errors->first('registercaptcha') }} </strong>
                                            @enderror
                                        </div>  --}}



                                        <label for="captcha">Please enter the CAPTCHA:</label>
                                        <img src="/captcha_code" alt="captcha"><br>
                                        <input class="mt-2 @error('captcha') is-invalid @enderror" type="text" id="captcha" name="captcha"><br>
                                            @error('captcha')
                                                <strong class="text-danger">{{ $errors->first('captcha') }} </strong>
                                            @enderror    
                                        <div>
                                            <a class="log-bn" href="#"><button type="submit">SUBmit</button></a>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $("#myForm").validate({
                rules: {
                    customername: {
                        required: true,
                    },
                    captcha: {
                        required: true,
                    },
                    customeremail: {
                        required: true,
                        customeremail: true,
                    },
                    customermobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirmpassword: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    customername: {
                        required: "Name is required",
                    },
                    captcha: {
                        required: "Captcha is required",
                    },
                    customeremail: {
                        required: "Email is required",
                        customeremail: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 50 characters",
                    },
                    customermobile: {
                        required: "Mobile is required",
                        minlength: "Mobile must be of 10 digits",
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be at least 5 characters",
                    },
                    confirmpassword: {
                        required: "Confirm password is required",
                        equalTo: "Password and confirm password should same",
                    },
                }
            });
        });
    </script>
@endsection

@section('scripts')
     <script src="{{ asset('assets/frontjs/jquery.validate.js') }}"></script>
  
    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: '../refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                    $(".captcha").load(window.location.href + " .captcha");

                }
            });
        });
        
        
        let passwords;

        function lgnpassword() {
            if (passwords == 1) {
                document.getElementById('password').type = 'password';
                document.getElementById('lgn-lock-icon').src = "{{ asset('assets/frontimages/icons/hide.png') }}";
                passwords = 0;
            } else {
                document.getElementById('password').type = 'text';
                document.getElementById('lgn-lock-icon').src = "{{ asset('assets/frontimages/icons/view.png') }}";
                passwords = 1;
            }
        }


        let passwords2;

        function lgnpassword2() {
            if (passwords2 == 1) {
                document.getElementById('ccpassword').type = 'password';
                document.getElementById('lgn-lock-icon2').src = "{{ asset('assets/frontimages/icons/hide.png') }}";
                passwords2 = 0;
            } else {
                document.getElementById('ccpassword').type = 'text';
                document.getElementById('lgn-lock-icon2').src = "{{ asset('assets/frontimages/icons/view.png') }}";
                passwords2 = 1;
            }
        }
    </script>
@endsection
