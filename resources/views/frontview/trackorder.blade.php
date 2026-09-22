@extends('layouts.front')
@section('title', 'Track Order')
@section('content')
    <main class="lord-page">
        <section class="lord-section">
            <div class="container">
                <!-- =================================================
                                                             PAGE HEADER
                                                        ================================================== -->
                <div class="lord-page-head">
                    <div>
                        <span class="lord-kicker">
                            YOUR SHOPPING JOURNEY
                        </span>
                        <h2>
                            Track
                            <em>Your Order</em>
                        </h2>
                        <p>
                            Enter your registered phone number to view your
                            order details and delivery status.
                        </p>
                    </div>
                    <a href="{{ url('products') }}" class="lord-shop-btn">
                        Continue Shopping
                        <span>
                            <i class="fa fa-long-arrow-right"></i>
                        </span>
                    </a>
                </div>
                <!-- =================================================
                                                     TRACK ORDER BY PHONE
                                                ================================================== -->

                <div class="lord-track-search-wrap">

                    <div class="lord-track-search-copy">

                        <span class="lord-track-search-icon">
                            <i class="fa fa-mobile"></i>
                        </span>

                        <div>
                            <small>
                                FIND YOUR ORDER
                            </small>

                            <h3>
                                Track order with your phone number
                            </h3>

                            <p>
                                Enter the mobile number used while placing your order.
                            </p>
                        </div>

                    </div>


                    <form action="{{ url()->current() }}" method="GET" class="lord-phone-form">

                        <div class="lord-phone-field">

                            <span class="lord-phone-prefix">
                                +91
                            </span>

                            <input type="tel" name="phone" id="lordPhone" value="{{ request('phone') }}"
                                placeholder="Enter 10 digit mobile number" maxlength="10" inputmode="numeric"
                                pattern="[0-9]{10}" required>

                        </div>


                        <button type="submit" class="lord-phone-submit">

                            <span>
                                Track Order
                            </span>

                            <i class="fa fa-long-arrow-right"></i>

                        </button>

                    </form>

                </div>
                <!-- =================================================
                                                             ORDERS LIST
                                                        ================================================== -->
                @php
                    $showOrders = !empty($orders) && $orders->count() > 0;
                @endphp

                <div class="lord-list" id="lordList" @if (!$showOrders) style="display:none;" @endif>
                    @if ($showOrders)
                        @foreach ($orders as $order)
                            @php
                                $items = $itemsByOrder[$order->order_id] ?? collect();
                                $orderTotal = (float) ($order->netAmount ?? 0);
                                if ($orderTotal <= 0) {
                                    $orderTotal = $items->sum(function ($item) {
                                        return (float) ($item->amount ?: $item->rate * $item->quantity);
                                    });
                                }
                            @endphp

                            <article class="lord-card" data-status="delivered" data-order="#LOLI{{ $order->order_id }}">
                                <div class="lord-card-head">
                                    <div class="lord-order-meta">
                                        <span class="lord-order-icon green-bg">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        <div>
                                            <small>
                                                ORDER NUMBER
                                            </small>
                                            <strong>
                                                {{ $order->order_id }}
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="lord-head-info">
                                        <div>
                                            <small>Order Date</small>
                                            <strong>{{ optional($order->created_at)->format('d M Y') ?? 'N/A' }}</strong>
                                        </div>
                                        <div>
                                            <small>Order Total</small>
                                            <strong>₹{{ number_format($orderTotal, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="lord-card-body">
                                    <div class="lord-products">
                                        @forelse($items as $item)
                                            @php
                                                $productImage = !empty($item->photo)
                                                    ? asset('Product/' . $item->photo)
                                                    : asset('assets/images/default-product.jpg');
                                                $lineTotal = (float) ($item->amount ?: $item->rate * $item->quantity);
                                            @endphp
                                            <div class="lord-product">
                                                <a href="{{ url('products') }}" class="lord-product-image">
                                                    <img src="{{ $productImage }}" alt="{{ $item->productname }}">
                                                    <span>{{ (int) ($item->quantity ?? 1) }}</span>
                                                </a>
                                                <div class="lord-product-info">
                                                    <span>
                                                        Product
                                                    </span>
                                                    <a href="{{ url('products') }}">
                                                        {{ $item->productname }}
                                                    </a>
                                                    <p>
                                                        Size: {{ $item->size ?? 'Standard' }}
                                                    </p>
                                                </div>
                                                <strong class="lord-product-price">
                                                    ₹{{ number_format($lineTotal, 2) }}
                                                </strong>
                                            </div>
                                        @empty
                                            <div class="lord-product">
                                                <div class="lord-product-info">
                                                    <span>Product</span>
                                                    <p>No product details available for this order.</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="lord-card-footer">
                                    <div class="lord-actions">
                                        <a href="{{ url('products') }}" class="lord-buy-btn">
                                            <i class="fa fa-refresh"></i>
                                            Buy Again
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
                <!-- =================================================
                                                             EMPTY RESULT
                                                        ================================================== -->
                <div class="lord-empty" id="lordEmpty" @if ($showOrders) style="display:none;" @endif>
                    <span>
                        <i class="fa fa-shopping-bag"></i>
                    </span>
                    <small>
                        NO ORDERS HERE
                    </small>
                    <h3>
                        No matching
                        <em>orders found.</em>
                    </h3>
                    <p>
                        Try another filter or explore our latest collection.
                    </p>
                    <a href="{{ url('products') }}">
                        Start Shopping
                        <span>
                            <i class="fa fa-long-arrow-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
