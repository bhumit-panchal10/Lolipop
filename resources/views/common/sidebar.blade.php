<!-- ========== App Menu ========== -->

<style>
    .nav-item:hover {
        background: #e7a4dfa7 !important;
        /*background:#d6a99d!important;*/
    }

    [data-layout=horizontal] .menu-dropdown,
    [data-layout=horizontal] .navbar-menu {
        background: #ab4ca0 !important;
    }
</style>
<div class="app-menu navbar-menu">


    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                @if (Auth::user()->role_id == 1)
                    <li class="menu-title"><span data-key="t-menu"></span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('home')) {{ 'active' }} @endif"
                            href="{{ route('home') }}">
                            <i class="mdi mdi-speedometer"></i>
                            <span data-key="t-dashboards">Dashboards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="sidebarMore">
                            <i class="ri-briefcase-2-line"></i> Master Entry </a>
                        <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('banner.index')) {{ 'active' }} @endif"
                                        href="{{ route('banner.index') }}">
                                        <i class="fa-regular fa-rectangle-list"></i>
                                        <span data-key="t-dashboards">Banner</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('attribute.index')) {{ 'active' }} @endif"
                                        href="{{ route('attribute.index') }}">
                                        <i class="fa-solid fa-box-open"></i>
                                        <span data-key="t-dashboards">Attribute</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('category.index')) {{ 'active' }} @endif"
                                        href="{{ route('category.index') }}">
                                        <i class="fa-regular fa-rectangle-list"></i>
                                        <span data-key="t-dashboards">Category</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('product.index')) {{ 'active' }} @endif"
                                        href="{{ route('product.index') }}">
                                        <i class="fa-solid fa-box-open"></i>
                                        <span data-key="t-dashboards">Product</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item">-->
                                <!--    <a class="nav-link menu-link @if (request()->routeIs('offer.index')) {{ 'active' }} @endif"-->
                                <!--        href="{{ route('offer.index') }}">-->
                                <!--        <i class="fa-solid fa-gift"></i>-->
                                <!--        <span data-key="t-dashboards">Offer</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('courier.index')) {{ 'active' }} @endif"
                                        href="{{ route('courier.index') }}">
                                        <i class="fa-solid fa-truck-ramp-box"></i>
                                        <span data-key="t-dashboards">Courier</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('metaData.index')) {{ 'active' }} @endif"
                                        href="{{ route('metaData.index') }}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <span data-key="t-dashboards">Seo</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('our-client.index') }}"
                                        class="nav-link {{ request()->is('admin/our-clients*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-handshake"></i>
                                        <span data-key="t-dashboards">Our Clients</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('testimonial.index') }}"
                                        class="nav-link {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-comment-dots"></i>
                                        <span data-key="t-dashboards">Testimonials</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link menu-link @if (request()->routeIs('order.index')) {{ 'active' }} @endif"-->
                    <!--        href="{{ route('order.pending') }}">-->
                    <!--        <i class="fa-solid fa-cart-shopping"></i>-->
                    <!--        <span data-key="t-dashboards">Order</span>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.pending') }}" data-bs-toggle="collapse"
                            role="button" aria-expanded="true" aria-controls="sidebarMore">
                            <i class="ri-briefcase-2-line"></i> Order </a>
                        <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('order.pending')) {{ 'active' }} @endif"
                                        href="{{ route('order.pending') }}">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        <span data-key="t-dashboards">Order</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('order.pendingOrder')) {{ 'active' }} @endif"
                                        href="{{ route('order.pendingOrder') }}">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        <span data-key="t-dashboards">Payment Pending</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>




                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('Inquiry.index')) {{ 'active' }} @endif"
                            href="{{ route('Inquiry.index') }}">
                            <i class="fa-solid fa-circle-question"></i>
                            <span data-key="t-dashboards">Inquiry</span>
                        </a>
                    </li>

                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link menu-link @if (request()->routeIs('metaData.index')) {{ 'active' }} @endif"-->
                    <!--        href="{{ route('metaData.index') }}">-->
                    <!--        <i class="fa-solid fa-magnifying-glass"></i>-->
                    <!--        <span data-key="t-dashboards">Seo</span>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="sidebarMore">
                            <i class="ri-briefcase-2-line"></i> Setting </a>
                        <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('setting.index')) {{ 'active' }} @endif"
                                        href="{{ route('setting.index') }}">
                                        <i class="fa-solid fa-star"></i>
                                        <span data-key="t-dashboards">Web Setting</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('otherpages.index')) {{ 'active' }} @endif"
                                        href="{{ route('otherpages.index') }}">
                                        <i class="fa-solid fa-star"></i>
                                        <span data-key="t-dashboards">Other Pages </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('stock.index')) {{ 'active' }} @endif"
                                        href="{{ route('stock.index') }}">
                                        <i class="fa-solid fa-star"></i>
                                        <span data-key="t-dashboards">Stock </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="sidebarMore">
                            <i class="ri-briefcase-2-line"></i> Reports </a>
                        <div class="menu-dropdown collapse show" id="sidebarMore" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('setting.index')) {{ 'active' }} @endif"
                                        href="{{ route('report.paymentReport') }}">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        <span data-key="t-dashboards">Payment Report</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('otherpages.index')) {{ 'active' }} @endif"
                                        href="{{ route('report.orderTracking') }}">
                                        <i class="fas fa-shipping-fast"></i>
                                        <span data-key="t-dashboards">Order Tracking</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('report.searchCustomer')) {{ 'active' }} @endif"
                                        href="{{ route('report.searchCustomer') }}">
                                        <i class="fa-solid fa-user"></i>
                                        <span data-key="t-dashboards">Customer Search</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('report.order_collection')) {{ 'active' }} @endif"
                                        href="{{ route('report.order_collection') }}">
                                        <i class="fa-solid fa-user"></i>
                                        <span data-key="t-dashboards">Order Collection</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link @if (request()->routeIs('report.total_sales')) {{ 'active' }} @endif"
                                        href="{{ route('report.total_sales') }}">
                                        <i class="fa-solid fa-user"></i>
                                        <span data-key="t-dashboards">Total Sales</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    {{--  <li class="nav-item">
                        <a target="_blank" class="nav-link menu-link"
                            href="https://marketingplatform.google.com/about/analytics/">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span data-key="t-dashboards">Google Analytics</span>
                        </a>
                    </li>  --}}
                @else
                    <li class="nav-item">
                        <a class="nav-link menu-link @if (request()->routeIs('order.userpending')) {{ 'active' }} @endif"
                            href="{{ route('order.userpending') }}">
                            <i class="ri-briefcase-2-line"></i>
                            <span data-key="t-dashboards">Order</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
