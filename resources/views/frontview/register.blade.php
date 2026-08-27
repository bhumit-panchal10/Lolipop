@extends('layouts.front')
@section('title', 'Register')
@section('content')

    @include('common.registeralert')
    <!-- Start Contact -->
    <section id="contact-us" class="contact-us section">
        <div class="container">
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-6 col-12 m-auto">
                        <div class="form-main">
                            <div class="title">
                                <h4>Sign Up</h4>
                                <!-- <h3>Write us a message</h3> -->
                            </div>
                            <form class="form" id="myForm" method="post" action="{{ route('registerstore') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Name<span>*</span></label>
                                            <input name="customername" type="text" placeholder=""
                                                value="{{ old('customername') }}" required autocomplete="off">
                                            @error('customername')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Email<span>*</span></label>
                                            <input name="customeremail" type="email" placeholder=""
                                                value="{{ old('customeremail') }}" required autocomplete="off">
                                            @error('customeremail')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Mobile<span>*</span></label>
                                            <input name="customermobile" maxlength="10" minlength="10"
                                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                value="{{ old('customermobile') }}" type="text" placeholder="" required
                                                autocomplete="off">
                                            @error('customermobile')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Your Alternative Mobile<span></span></label>
                                            <input name="customermobile1" type="text" maxlength="10" minlength="10"
                                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                value="{{ old('customermobile1') }}" placeholder="" autocomplete="off">
                                            @error('customermobile1')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <label for="captcha">Please enter the CAPTCHA:</label>
                                    <img src="/captcha_code" alt="captcha"><br>
                                    <input class="mt-2 @error('captcha') is-invalid @enderror" type="text" id="captcha"
                                        name="captcha"><br>
                                    @error('captcha')
                                        <strong class="text-danger">{{ $errors->first('captcha') }} </strong>
                                    @enderror


                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="submit" class="btn ">Sign Up</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-12">
                                        <span class="signup">Already Have an account <a href="{{ route('FrontLogin') }}"
                                                class="fw-bold">Login here</a></span>
                                        <br><br>
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


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#myForm").validate({
                rules: {
                    customername: {
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
                    },
                    captcha: {
                        required: true,
                    },
                },
                messages: {
                    customername: {
                        required: "Name is required",
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
                    captcha: {
                        required: "Captcha is required",
                    },
                }
            });
        });
    </script>
@endsection

@section('scripts')

@endsection
