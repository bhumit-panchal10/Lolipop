@extends('layouts.front')
@section('title', 'Thank You')

@section('content')

    <style>
        .thankyou-page {
            min-height: 65vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 70px 20px;
            background: linear-gradient(135deg, #fff6fb 0%, #f7f9ff 50%, #fffdf0 100%);
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .thankyou-page::before,
        .thankyou-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }

        .thankyou-page::before {
            width: 220px;
            height: 220px;
            background: rgba(220, 51, 139, 0.08);
            top: -100px;
            left: -70px;
        }

        .thankyou-page::after {
            width: 280px;
            height: 280px;
            background: rgba(255, 199, 29, 0.10);
            bottom: -150px;
            right: -80px;
        }

        .thankyou-card {
            width: 100%;
            max-width: 750px;
            background: #ffffff;
            border-radius: 28px;
            padding: 55px 45px;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 18px 55px rgba(31, 45, 61, 0.12);
            border: 1px solid rgba(220, 51, 139, 0.08);
        }

        .thankyou-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dc338b, #ef4fa3);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 25px rgba(220, 51, 139, 0.25);
        }

        .thankyou-icon i {
            color: #ffffff;
            font-size: 42px;
        }

        .thankyou-small-title {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 30px;
            background: #fff0f8;
            color: #dc338b;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .thankyou-title {
            margin: 0 0 15px;
            color: #243442;
            font-size: 52px;
            line-height: 1.1;
            font-weight: 800;
        }

        .thankyou-title span {
            color: #dc338b;
        }

        .thankyou-text {
            max-width: 580px;
            margin: 0 auto 30px;
            color: #607080;
            font-size: 17px;
            line-height: 1.8;
        }

        .thankyou-note {
            color: #84909b;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .thankyou-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-width: 190px;
            padding: 14px 24px;
            border-radius: 35px;
            background: #243442;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.3s ease;
        }

        .thankyou-btn i {
            font-size: 16px;
        }

        .thankyou-btn:hover {
            background: #dc338b;
            color: #ffffff !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(220, 51, 139, 0.25);
        }

        /* Mobile */
        @media (max-width: 767px) {

            .thankyou-page {
                min-height: auto;
                padding: 50px 15px;
            }

            .thankyou-card {
                padding: 40px 22px;
                border-radius: 22px;
            }

            .thankyou-icon {
                width: 75px;
                height: 75px;
                margin-bottom: 20px;
            }

            .thankyou-icon i {
                font-size: 34px;
            }

            .thankyou-small-title {
                font-size: 11px;
                padding: 7px 14px;
                letter-spacing: 1px;
            }

            .thankyou-title {
                font-size: 36px;
            }

            .thankyou-text {
                font-size: 15px;
                line-height: 1.7;
            }

            .thankyou-note {
                font-size: 13px;
            }

            .thankyou-btn {
                width: 100%;
                max-width: 230px;
            }
        }

        @media (max-width: 400px) {

            .thankyou-page {
                padding: 40px 12px;
            }

            .thankyou-card {
                padding: 35px 18px;
            }

            .thankyou-title {
                font-size: 31px;
            }

            .thankyou-text {
                font-size: 14px;
            }
        }
    </style>


    <!-- Thank You Page -->
    <section class="thankyou-page">

        <div class="thankyou-card">

            <!-- Icon -->
            <div class="thankyou-icon">
                <i class="fa fa-check"></i>
            </div>

            <!-- Small Heading -->
            <div class="thankyou-small-title">
                Message Received
            </div>

            <!-- Main Heading -->
            <h1 class="thankyou-title">
                Thank <span>You!</span>
            </h1>

            <!-- Description -->
            <p class="thankyou-text">
                Thank you for contacting us! We have received your message
                and our team will get back to you soon.
                We truly appreciate you taking the time to reach out to us.
            </p>

            <p class="thankyou-note">
                We look forward to helping you and your little one.
            </p>

            <!-- Back Button -->
            <a href="{{ route('FrontIndex') }}" class="thankyou-btn">
                <i class="fa fa-home"></i>
                <span>Back to Home</span>
            </a>

        </div>

    </section>

@endsection
