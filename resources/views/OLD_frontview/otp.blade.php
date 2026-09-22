@extends('layouts.front')
@section('title', 'Otp')
@section('content')
    @include('common.loginsuccessfailalert')
    <!-- Start Contact -->
    <section id="contact-us" class="contact-us section">
        <div class="container">
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-6 col-12 m-auto">
                        <div class="form-main">
                            <div class="title">
                                <h4>OTP</h4>
                                <!-- <h3>Write us a message</h3> -->
                            </div>
                            <form class="form" method="post" action="{{ route('FrontOtpSubmit') }}">
                                @csrf
                                <input type="hidden" name="guid" value="{{ $guid }}">
                                <div class="row">

                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <label>Your OTP<span>*</span></label>
                                            <input name="otp" type="text" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="submit" class="btn ">Submit</button>
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

@endsection
