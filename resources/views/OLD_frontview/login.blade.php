@extends('layouts.front')
@section('title', 'Track Order')
@section('content')
    @include('common.loginsuccessfailalert')
    <!-- Start Contact -->
    
   
    <section id="contact-us" class="contact-us section track">
        <div class="container">
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-6 col-12 m-auto">
                        <div class="form-main">
                            <div class="title">
                                <h4>Track Order</h4>
                                <!-- <h3>Write us a message</h3> -->
                            </div>
                            <form class="form" method="post" action="{{ route('FrontLoginStore') }}">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <label>Your Mobile<span>*</span></label>
                                            <input name="customermobile" type="text" maxlength="10" minlength="10"
                                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                placeholder="" required autocomplete="off">
                                            @error('customermobile')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-12">
                                        {{--  <a href="#">
                                            Forgot Password?
                                        </a>  --}}
                                        <br><br>
                                    </div>
                                    <div class="col-lg-7 col-12">
                                        <span class="signup">Dont have an account yet? <a
                                                href="{{ route('FrontRegister') }}" class="fw-bold">sign up</a></span>
                                        <br><br>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="submit" class="btn ">Track Order</button>
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

@section('scripts')
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
                    customermobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                },
                messages: {
                    customermobile: {
                        required: "Mobile is required",
                        minlength: "Mobile must be of 10 digits",
                    },
                }
            });
        });
    </script>
@endsection
