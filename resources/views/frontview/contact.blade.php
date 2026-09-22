@extends('layouts.front')
@section('title', 'Contact')
@section('content')

    @include('common.contactalert')
    <style>
        /* .captcha {
                                                                                display: flex;
                                                                                align-items: center;
                                                                                gap: 10px;
                                                                            }

                                                                            .captcha span {
                                                                                display: inline-flex;
                                                                                align-items: center;
                                                                            }

                                                                            .captcha span img {
                                                                                display: block;
                                                                                max-height: 45px;
                                                                            }

                                                                            .captcha #reload {
                                                                                width: 45px;
                                                                                height: 45px;
                                                                                padding: 0;
                                                                                display: inline-flex;
                                                                                align-items: center;
                                                                                justify-content: center;
                                                                                font-size: 24px;
                                                                                line-height: 1;
                                                                                border-radius: 4px;
                                                                                cursor: pointer;
                                                                            } */

        #reload {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: #fff !important;
            width: 45px;
            height: 45px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
        }

        #reload:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }
    </style>
    <main class="lcx-contact-page">

        <section class="lcx-contact-section">
            <div class="container">
                <div class="lcx-contact-grid">

                    <div class="lcx-form-side">
                        <div class="lcx-mini-label">
                            <span></span>
                            Get In Touch Today
                        </div>
                        <div class="lcx-heading">
                            <h2>
                                We're always happy to
                                <em>assist You.</em>
                            </h2>
                            <p>
                                Have questions about products, sizes,
                                orders or delivery? Send us a message
                                and our team will be happy to help.
                            </p>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Please check the highlighted fields and try again.
                            </div>
                        @endif
                        <form action="{{ route('contact_us') }}" class="lcx-form" id="lcxContactForm" method="POST">
                            @csrf
                            <!-- NAME ROW -->
                            <div class="lcx-form-row">
                                <div class="lcx-field">
                                    <label>
                                        First Name
                                    </label>
                                    <div class="lcx-input-wrap">
                                        <i class="fa fa-user-o"></i>
                                        <input type="text" name="first_name" placeholder="First Name" id="lcxFirstName"
                                            value="{{ old('first_name') }}" required>
                                    </div>
                                </div>
                                <div class="lcx-field">
                                    <label>
                                        Last Name
                                    </label>
                                    <div class="lcx-input-wrap">
                                        <i class="fa fa-user-o"></i>
                                        <input type="text" name="last_name" placeholder="Last Name" id="lcxLastName"
                                            value="{{ old('last_name') }}" required>
                                    </div>
                                </div>
                            </div>
                            <!-- EMAIL + PHONE -->
                            <div class="lcx-form-row">
                                <div class="lcx-field">
                                    <label>
                                        Email Address
                                    </label>
                                    <div class="lcx-input-wrap">
                                        <i class="fa fa-envelope-o"></i>
                                        <input type="email" name="email" placeholder="Email Address" id="lcxEmail"
                                            value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="lcx-field">
                                    <label>
                                        Phone Number
                                    </label>
                                    <div class="lcx-input-wrap">
                                        <i class="fa fa-phone"></i>
                                        <input type="text" name="phone_number" placeholder="Phone Number" id="lcxPhone"
                                            value="{{ old('phone_number') }}" maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                    </div>
                                </div>
                            </div>
                            <!-- SUBJECT -->
                            <div class="lcx-field">
                                <label>
                                    How Can We Help?
                                </label>
                                <div class="lcx-select-wrap">
                                    <i class="fa fa-comment-o"></i>
                                    <select id="lcxSubject" name="subject" required>

                                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>
                                            Select Enquiry Type
                                        </option>

                                        <option value="product_inquiry"
                                            {{ old('subject') == 'product_inquiry' ? 'selected' : '' }}>
                                            Product Enquiry
                                        </option>

                                        <option value="size" {{ old('subject') == 'size' ? 'selected' : '' }}>
                                            Size Help
                                        </option>

                                        <option value="order_related"
                                            {{ old('subject') == 'order_related' ? 'selected' : '' }}>
                                            Order Related
                                        </option>

                                        <option value="shipping_delivery"
                                            {{ old('subject') == 'shipping_delivery' ? 'selected' : '' }}>
                                            Shipping & Delivery
                                        </option>

                                        <option value="Return_exchange"
                                            {{ old('subject') == 'Return_exchange' ? 'selected' : '' }}>
                                            Return & Exchange
                                        </option>

                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>

                                    </select>
                                    <i class="fa fa-angle-down"></i>
                                </div>
                            </div>
                            <!-- MESSAGE -->
                            <div class="lcx-field">
                                <label>
                                    Message
                                </label>
                                <div class="lcx-textarea-wrap">
                                    <i class="fa fa-commenting-o"></i>
                                    <textarea id="lcxMessage" name="message" placeholder="Tell us how we can help..." required>{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <div class="lcx-field {{ $errors->has('captcha') ? 'has-error' : '' }}">

                                <div class="lcx-field mt-4 mb-4">
                                    <div class="captcha">
                                        <span>{!! captcha_img() !!}</span>

                                        <button type="button" class="btn btn-danger reload" id="reload">
                                            &#x21bb;
                                        </button>
                                    </div>
                                </div>
                                <div class="lcx-input-wrap col-md-6">
                                    <i class="fa fa-refresh"></i>
                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                        name="captcha" value="{{ old('captcha') }}" required>
                                </div>
                                @error('captcha')
                                    <span class="help-block text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>


                            <!-- BUTTON -->
                            <button type="submit" class="lcx-submit-btn">
                                <span>
                                    <i class="fa fa-paper-plane-o"></i>
                                </span>
                                <strong>
                                    Send Message
                                </strong>
                                <i class="fa fa-long-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="lcx-image-side">

                        <span class="lcx-deco lcx-deco-one"></span>
                        <span class="lcx-deco lcx-deco-two"></span>
                        <div class="lcx-image-card">
                            <img src="{{ asset('/Front/assets/images/contact.webp') }}" alt="Lolipop customer support">

                            <div class="lcx-contact-info">
                                <span class="lcx-info-label">
                                    CONTACT INFORMATION
                                </span>
                                <h3>
                                    Let's stay connected.
                                </h3>
                                <div class="lcx-info-line"></div>
                                <!-- PHONE -->

                                <div class="lcx-info-item">

                                    <span class="lcx-info-icon blue">
                                        <i class="fa fa-phone"></i>
                                    </span>

                                    <div>

                                        <small>
                                            CALL US
                                        </small>

                                        <strong>
                                            <a href="tel:+919773201361">
                                                +91 97732 01361
                                            </a>
                                        </strong>

                                        <strong>
                                            <a href="tel:+919228195898">
                                                +91 92281 95898
                                            </a>
                                        </strong>

                                    </div>

                                </div>
                                <!-- EMAIL -->
                                <a href="mailto:firefashion313@gmail.com" class="lcx-info-item">
                                    <span class="lcx-info-icon pink">
                                        <i class="fa fa-envelope-o"></i>
                                    </span>
                                    <div>
                                        <small>
                                            EMAIL US
                                        </small>
                                        <strong>
                                            firefashion313@gmail.com
                                        </strong>
                                    </div>
                                </a>
                                <!-- ADDRESS -->
                                <a href="https://maps.app.goo.gl/jyZdJJLpuaR6XrG88" target="_blank"
                                    class="lcx-info-item">
                                    <span class="lcx-info-icon green">
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                    <div>
                                        <small>
                                            VISIT US
                                        </small>
                                        <strong>
                                            F-1,Gold Plaza,Opp. HDFC Bank, Navjivan Mill Compound, Kalol,
                                            <!--Gujarat 382721.-->
                                        </strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                                                                                                                                                                                                                        VISIT STORE SECTION
                                                                                                                                                                                                                    ================================================== -->
        <section class="lcx-store-section">
            <div class="container">
                <div class="lcx-store-heading">
                    <div class="lcx-mini-label center">
                        <span></span>
                        Visit Our Location
                    </div>
                    <h2>
                        Visit Our
                        <em>Happy Little Store.</em>
                    </h2>
                    <p>
                        Come explore colourful styles, find the perfect
                        size and shop your favourites in person.
                    </p>
                </div>
                <div class="lcx-store-layout">

                    <!-- MAP -->
                    <div class="lcx-map-card">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3666.027152594467!2d72.50007947429344!3d23.242098979020465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c253bf3305597%3A0x4333ef5ebbc7b11e!2sLolipop%20childrenwear!5e0!3m2!1sen!2sin!4v1787560896850!5m2!1sen!2sin"
                            loading="lazy" allowfullscreen></iframe>

                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#myForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    your_message: {
                        required: true,
                    },
                    captcha: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Name is required",
                    },
                    subject: {
                        required: "Subject is required",
                    },
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                    },
                    mobile: {
                        required: "Mobile is required",
                        minlength: "Mobile must be of 10 digits",
                    },
                    your_message: {
                        required: "Message is required",
                    },
                    captcha: {
                        required: "Captcha is required",
                    },
                }
            });
        });
    </script>
@endsection
