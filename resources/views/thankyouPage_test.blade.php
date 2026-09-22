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
            border: 1px solid #80563e;
            border-radius: 10px;
            padding: 25px;
            background: #fff;
        }
    </style>

    <!-- Banner -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
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
    </section>

    <div class="bg0 p-t-50 p-b-80">
        <div class="container">

            <!-- Thank You Card -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="card-box text-center">
                        <h2 class="mb-3">Thank You!</h2>
                        <p>Your order has been placed successfully.</p>
                        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card-box">
                        <h5>Customer Details</h5>
                        <p><strong>Name:</strong> {{ $order->shipping_cutomerName }}</p>
                        <p><strong>Mobile:</strong> {{ $order->shipping_mobile }}</p>
                        <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-box">
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
            <div class="card-box">
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
                                    <td>{{ $item->productname }}</td>
                                    <td>
                                        <img src="http://127.0.0.1:8000//Product/{{ $item->photo }}" width="60">
                                    </td>
                                    <td>{{ $attr->product_attribute_size ?? '-' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₹ {{ number_format($item->rate, 2) }}</td>
                                    <td>₹ {{ number_format($total, 2) }}</td>
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
