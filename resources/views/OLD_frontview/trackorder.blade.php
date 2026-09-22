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
                            My
                            <em>Orders</em>
                        </h2>
                        <p>
                            View your orders, check delivery status
                            and shop your favourite styles again.
                        </p>
                    </div>
                    <a href="product.html?gender=girls" class="lord-shop-btn">
                        Continue Shopping
                        <span>
                            <i class="fa fa-long-arrow-right"></i>
                        </span>
                    </a>
                </div>
                <!-- =================================================
                             FILTER TABS
                        ================================================== -->
                <div class="lord-toolbar">
                    <div class="lord-tabs">
                        <button type="button" class="active" data-order-filter="all">
                            All Orders
                        </button>
                        <button type="button" data-order-filter="shipped">
                            Shipped
                        </button>
                        <button type="button" data-order-filter="delivered">
                            Delivered
                        </button>
                        <button type="button" data-order-filter="cancelled">
                            Cancelled
                        </button>
                    </div>
                    <div class="lord-search">
                        <i class="fa fa-search"></i>
                        <input type="text" id="lordSearch" placeholder="Search order...">
                    </div>
                </div>
                <!-- =================================================
                             ORDERS LIST
                        ================================================== -->
                <div class="lord-list" id="lordList">
                    <!-- =============================================
                                 ORDER 01 - SHIPPED
                            ============================================== -->
                    <article class="lord-card" data-status="shipped" data-order="#LOLI10245">
                        <!-- HEADER -->
                        <div class="lord-card-head">
                            <div class="lord-order-meta">
                                <span class="lord-order-icon">
                                    <i class="fa fa-cube"></i>
                                </span>
                                <div>
                                    <small>
                                        ORDER NUMBER
                                    </small>
                                    <strong>
                                        #LOLI10245
                                    </strong>
                                </div>
                            </div>
                            <div class="lord-head-info">
                                <div>
                                    <small>Order Date</small>
                                    <strong>18 Aug 2026</strong>
                                </div>
                                <div>
                                    <small>Order Total</small>
                                    <strong>₹2,098</strong>
                                </div>
                            </div>
                            <span class="lord-status shipped">
                                <i class="fa fa-truck"></i>
                                Shipped
                            </span>
                        </div>
                        <!-- BODY -->
                        <div class="lord-card-body">
                            <!-- PRODUCTS -->
                            <div class="lord-products">
                                <!-- PRODUCT -->
                                <div class="lord-product">
                                    <a href="product-detail.html?id=1" class="lord-product-image">
                                        <img src="assets/images/girls-dresses.jpg" alt="Floral Summer Dress">
                                        <span>1</span>
                                    </a>
                                    <div class="lord-product-info">
                                        <span>
                                            Girls • Dresses
                                        </span>
                                        <a href="product-detail.html?id=1">
                                            Floral Summer Dress
                                        </a>
                                        <p>
                                            Pink
                                            <i></i>
                                            Size M
                                        </p>
                                    </div>
                                    <strong class="lord-product-price">
                                        ₹1,099
                                    </strong>
                                </div>
                                <!-- PRODUCT -->
                                <div class="lord-product">
                                    <a href="product-detail.html?id=2" class="lord-product-image">
                                        <img src="assets/images/boys-shirts.jpg" alt="Classic Checked Shirt">
                                        <span>1</span>
                                    </a>
                                    <div class="lord-product-info">
                                        <span>
                                            Boys • Shirts
                                        </span>
                                        <a href="product-detail.html?id=2">
                                            Classic Checked Shirt
                                        </a>
                                        <p>
                                            Blue
                                            <i></i>
                                            Size S
                                        </p>
                                    </div>
                                    <strong class="lord-product-price">
                                        ₹999
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <!-- FOOTER -->
                        <div class="lord-card-footer">
                            <div class="lord-payment">
                                <i class="fa fa-credit-card"></i>
                                <span>
                                    Paid via UPI
                                </span>
                            </div>
                            <div class="lord-actions">
                                <a href="track-order.html" class="lord-track-btn">
                                    <i class="fa fa-map-marker"></i>
                                    Track Order
                                </a>
                                <a href="order-detail.html?id=10245" class="lord-detail-btn">
                                    View Details
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    <!-- =============================================
                                 ORDER 02 - DELIVERED
                            ============================================== -->
                    <article class="lord-card" data-status="delivered" data-order="#LOLI10187">
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
                                        #LOLI10187
                                    </strong>
                                </div>
                            </div>
                            <div class="lord-head-info">
                                <div>
                                    <small>Order Date</small>
                                    <strong>08 Aug 2026</strong>
                                </div>
                                <div>
                                    <small>Order Total</small>
                                    <strong>₹749</strong>
                                </div>
                            </div>
                            <span class="lord-status delivered">
                                <i class="fa fa-check-circle"></i>
                                Delivered
                            </span>
                        </div>
                        <div class="lord-card-body">
                            <div class="lord-products">
                                <div class="lord-product">
                                    <a href="product-detail.html?id=3" class="lord-product-image">
                                        <img src="assets/images/baby-rompers.jpg" alt="Soft Cotton Baby Romper">
                                        <span>1</span>
                                    </a>
                                    <div class="lord-product-info">
                                        <span>
                                            Baby • Rompers
                                        </span>
                                        <a href="product-detail.html?id=3">
                                            Soft Cotton Baby Romper
                                        </a>
                                        <p>
                                            Green
                                            <i></i>
                                            Size XS
                                        </p>
                                    </div>
                                    <strong class="lord-product-price">
                                        ₹749
                                    </strong>
                                </div>
                            </div>
                            <div class="lord-delivered-box">
                                <span>
                                    <i class="fa fa-check"></i>
                                </span>
                                <div>
                                    <strong>
                                        Delivered Successfully
                                    </strong>
                                    <p>
                                        Delivered on 11 Aug 2026
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="lord-card-footer">
                            <div class="lord-payment">
                                <i class="fa fa-money"></i>
                                <span>
                                    Cash On Delivery
                                </span>
                            </div>
                            <div class="lord-actions">
                                <a href="product-detail.html?id=3" class="lord-buy-btn">
                                    <i class="fa fa-refresh"></i>
                                    Buy Again
                                </a>
                                <a href="order-detail.html?id=10187" class="lord-detail-btn">
                                    View Details
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- =================================================
                             EMPTY RESULT
                        ================================================== -->
                <div class="lord-empty" id="lordEmpty">
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
                    <a href="product.html?gender=girls">
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
