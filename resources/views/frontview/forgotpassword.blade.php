@extends('layouts.front')
@section('title', 'Forgot Password')
@section('content')

    <section id="contact-us" class="contact-us section">
        <div class="container">
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-6 col-12 m-auto">
                        <div class="form-main">
                            <div class="title">
                                <h4>Forgot Your Password?</h4>
                            </div>
                            <form class="form" method="post" action="{{ route('forgotpasswordsubmit') }}">
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


                                    <div class="col-12">
                                        <div class="form-group button">
                                            <button type="submit" class="btn ">Send My Password</button>
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
@endsection

@section('scripts')
@endsection
