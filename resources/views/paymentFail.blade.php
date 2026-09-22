@extends('layouts.front')
@section('title', 'Payment Fail')
@section('content')

    <style>
        .payment-fail-page {
            background: #fff8f5;
            min-height: 72vh;
            padding: 58px 15px 90px;
        }

        .payment-fail-card {
            background: #fff;
            border: 1px solid #f0ded8;
            border-radius: 22px;
            box-shadow: 0 15px 35px rgba(23, 40, 61, .08);
            margin: auto;
            max-width: 620px;
            padding: 42px 30px;
            text-align: center;
        }

        .payment-fail-icon {
            align-items: center;
            background: #ffe1e8;
            border-radius: 50%;
            color: #df4e75;
            display: flex;
            font-size: 32px;
            height: 72px;
            justify-content: center;
            margin: 0 auto 20px;
            width: 72px;
        }

        .payment-fail-card h1 {
            color: #17283d;
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .payment-fail-card p {
            color: #778394;
            line-height: 1.7;
            margin: 0 auto 24px;
            max-width: 440px;
        }

        .payment-fail-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .payment-fail-actions a {
            border-radius: 24px;
            display: inline-block;
            font-weight: 700;
            padding: 12px 22px;
            text-decoration: none;
        }

        .payment-fail-retry {
            background: #e54f87;
            color: #fff;
        }

        .payment-fail-cart {
            border: 1px solid #d7c4bd;
            color: #17283d;
        }

        @media (max-width: 575px) {
            .payment-fail-page {
                padding: 34px 12px 60px;
            }

            .payment-fail-card {
                padding: 32px 20px;
            }

            .payment-fail-card h1 {
                font-size: 28px;
            }
        }
    </style>

    <main class="payment-fail-page">
        <div class="payment-fail-card">
            <div class="payment-fail-icon"><i class="fa fa-exclamation"></i></div>
            <h1>Payment was not completed</h1>
            <p>Your payment could not be processed. No amount should be charged. Please try again or return to your cart and
                review your order.</p>
            <div class="payment-fail-actions">
                <a class="payment-fail-retry" href="javascript:history.back()">Try Payment Again</a>
                <a class="payment-fail-cart" href="{{ route('cart.list') }}">Back To Cart</a>
            </div>
        </div>
    </main>
@endsection

@section('scripts')

@endsection
