@extends('layouts.front')
@section('title', 'Success')

@section('content')

    <div class="overlay" id="overlay">
        <div class="loader"></div>
    </div>

    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #8c563d;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .card-box {
            border: 1px solid #f0ded8;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(23, 40, 61, .06);
            padding: 25px;
            background: #fff;
        }

        .success-page {
            background: #fff8f5;
            box-sizing: border-box;
            color: #17283d;
            padding: 42px 0 80px;
            width: 100%;
        }

        .success-page *,
        .success-page *::before,
        .success-page *::after {
            box-sizing: border-box;
        }

        .success-page .container {
            max-width: 1080px;
            width: 100%;
        }

        .success-page .row {
            margin-left: -10px;
            margin-right: -10px;
        }

        .success-page .row>[class*="col-"] {
            padding-left: 10px;
            padding-right: 10px;
        }

        .success-hero {
            background: #17283d;
            border: 0;
            color: #fff;
            overflow: hidden;
            padding: 38px;
            position: relative;
        }

        .success-hero::after {
            border: 34px solid #f26b9f;
            border-radius: 50%;
            content: '';
            height: 190px;
            opacity: .8;
            position: absolute;
            right: -65px;
            top: -95px;
            width: 190px;
        }

        .success-hero h2 {
            color: #fff;
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .success-hero p {
            color: #dbe5ef;
            margin-bottom: 4px;
        }

        .success-hero strong {
            color: #ffd166;
        }

        .success-panel h5 {
            color: #17283d;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .success-panel p {
            color: #526276;
            line-height: 1.7;
        }

        .success-grid>div {
            margin-bottom: 0;
        }

        .success-page .table {
            margin-bottom: 0;
        }

        .success-page .table thead {
            background: #17283d !important;
        }

        .success-page .table th {
            border: 0;
            font-size: 12px;
            letter-spacing: .04em;
            padding: 13px 10px;
            text-transform: uppercase;
        }

        .success-page .table td {
            border-color: #f0e5e0;
            color: #526276;
            padding: 13px 10px;
            vertical-align: middle;
        }

        .success-page .table img {
            background: #fff8f5;
            border-radius: 10px;
            object-fit: cover;
        }

        .success-page .text-end h5 {
            color: #17283d;
            font-size: 16px;
        }

        .success-page .text-end h5:last-child {
            color: #e54f87;
            font-size: 20px;
        }

        @media (max-width: 767px) {
            .success-page {
                padding: 24px 0 55px;
            }

            .success-page .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .success-page .row {
                margin-left: 0;
                margin-right: 0;
            }

            .success-page .row>[class*="col-"] {
                padding-left: 0;
                padding-right: 0;
            }

            .success-hero {
                padding: 28px 22px;
            }

            .success-hero h2 {
                font-size: 30px;
            }

            .success-page .card-box {
                padding: 20px;
            }

            .success-page .table-responsive {
                overflow: visible;
            }

            .success-page .table {
                display: block;
                width: 100%;
            }

            .success-page .table thead {
                display: none;
            }

            .success-page .table tbody,
            .success-page .table tr,
            .success-page .table td {
                display: block;
                width: 100%;
            }

            .success-page .table tr {
                border-bottom: 1px solid #f0e5e0;
                padding: 12px 0;
            }

            .success-page .table tr:last-child {
                border-bottom: 0;
            }

            .success-page .table td {
                border: 0;
                display: flex;
                justify-content: space-between;
                gap: 14px;
                padding: 6px 0;
                text-align: right;
            }

            .success-page .table td::before {
                color: #778394;
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
            }

            .success-page .table td:first-child {
                display: none;
            }

            .success-page .table td:nth-child(3) {
                align-items: center;
            }

            .success-page .table td:nth-child(3)::before {
                align-self: center;
            }

            .success-page .table img {
                height: 58px;
                width: 58px;
            }

            .success-page .text-end {
                text-align: left !important;
            }
        }
    </style>

    <!-- Banner -->
    {{--  <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url({{ asset('assets/frontimages/catagory/SHOP.jpg') }});">
        <div class="container">
            <div class="bredcrum">
                <ul>
                    <li><a class="text-white" href="{{ route('FrontIndex') }}">Home</a></li>
                    <li><img src="{{ asset('assets/images/breadcrumb.png') }}"></li>
                    <li class="text-white">Order Success</li>
                </ul>
            </div>
        </div>
    </section>  --}}

    <div class="success-page">
        <div class="container">

            <!-- Thank You Card -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="card-box success-hero text-center">
                        <h2 class="mb-3">Thank You!</h2>
                        <p>Your order has been placed successfully.</p>
                        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card-box success-panel">
                        <h5>Customer Details</h5>
                        <p><strong>Name:</strong> {{ $order->shipping_cutomerName }}</p>
                        <p><strong>Mobile:</strong> {{ $order->shipping_mobile }}</p>
                        <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-box success-panel">
                        <h5>Shipping Address</h5>
                        <p>
                            {{ $order->shiiping_address1 }},
                            {{ $order->shiiping_address2 }}<br>
                            {{ $order->shipping_city }},
                            {{ $stateName }}<br>
                            {{ $order->shipping_pincode }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Table -->
            <div class="card-box success-panel">
                <h5 class="mb-3">Order Details</h5>

                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead style="background:#80563e;color:#fff;">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orderDetails as $key => $item)
                                @php
                                    $attr = \App\Models\ProductAttributes::where('id', $item->size)->first();
                                    $total = $item->quantity * $item->rate;
                                @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td data-label="Product">{{ $item->productname }}</td>
                                    <td data-label="Image">
                                        <img src="{{ $item->photo ? asset('Product/Thumbnail/' . $item->photo) : asset('assets/images/no-image.jpg') }}"
                                            width="60" alt="{{ $item->productname }}">
                                    </td>
                                    <td data-label="Size">{{ $attr->product_attribute_size ?? '-' }}</td>
                                    <td data-label="Quantity">{{ $item->quantity }}</td>
                                    <td data-label="Rate">₹ {{ number_format($item->rate, 2) }}</td>
                                    <td data-label="Total">₹ {{ number_format($total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="text-end mt-3">
                    <h5><strong>Total Amount:</strong> ₹ {{ number_format($order->amount, 2) }}</h5>
                    <h5><strong>Net Amount:</strong> ₹ {{ number_format($order->netAmount, 2) }}</h5>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const overlay = document.getElementById('overlay');

        function showLoader() {
            overlay.style.display = 'flex';
        }

        function hideLoader() {
            overlay.style.display = 'none';
        }

        showLoader();

        window.addEventListener('load', function() {
            hideLoader();
        });
    </script>
@endsection
