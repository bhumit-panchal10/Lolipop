@extends('layouts.front')
@section('title', 'New Password')
@section('content')
    <section class="sec-padcn">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-11 col-lg-10">
                    <div class="row fm-shd">
                        <div class="col-lg-6 px-0">
                            <div class="log-img">
                                <img class="img-fluid" src="{{ asset('assets/frontimages/banner/slide-cn.avif') }}"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="cn-pdt">

                                <div class="text-center">
                                    <img width="100" class="img-fluid mb-5 mt-2"
                                        src="{{ asset('assets/frontimages/icons/MB.png') }}" alt="">
                                    <p class="text-center sin">NEW PASSWORD</p>
                                </div>

                                <div class="cn-dt">
                                    <form id="myForm" action="{{ route('newpasswordsubmit') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div>
                                            <span class="lnr lnr-lock ps2-cion-cpass"></span>
                                            <input type="password" name="newpassword" id="newpassword" placeholder="Enter your Password"
                                                id="sfpassword" required>
                                        </div>
                                        <div>
                                            <span class="lnr lnr-lock pscn2-cion-cpass2"></span>
                                            <input type="password" name="confirmpassword" placeholder="Confirm Password"
                                                id="ccpassword" required>
                                        </div>

                                        <div>
                                            <a class="log-bn" href="#"><button type="submit">submit</button></a>
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
                    newpassword: {
                        required: true,
                        minlength: 5
                    },
                    confirmpassword: {
                        required: true,
                        equalTo: "#newpassword"
                    }
                },
                messages: {
                    newpassword: {
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
