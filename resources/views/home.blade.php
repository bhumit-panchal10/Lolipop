@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    a{text-decoration:none;}
    .card-body{height:148px;}
</style>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        {{--  <div class="auth-one-bg-position auth-one-bg" id="auth-particles" style="height: 600px">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>  --}}

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col">

                        <div class="h-100">
                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            {{--  <h4 class="fs-16 mb-1">Admin Login</h4>  --}}
                                        </div>

                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                            
                            

                            <div class="row">
                                
                                @if(Auth::user()->role_id == 1)
                                    <!-- <div class="col-xl-3 col-md-6">-->
                                         <!--card -->
                                    <!--    <div class="card card-animate"  style="background: #570f29;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark text-truncate mb-0">-->
                                    <!--                        Attribute</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span-->
                                    <!--                            class="counter-value" data-target="{{ $Attribute }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('attribute.index') }}"-->
                                    <!--                        class="text-decoration-underline text-dark-50">-->
                                    <!--                        View Attribute</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                    <!--                        <i class="fa-solid fa-building"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <!--<div class="col-xl-3 col-md-6">-->
                                    <!--    <div class="card card-animate" style="background: #055d83;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark-50 text-truncate mb-0">-->
                                    <!--                        Banner</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span-->
                                    <!--                            class="counter-value"-->
                                    <!--                            data-target="{{ $Banner }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('banner.index') }}"-->
                                    <!--                        class="text-decoration-underline text-dark-50">View-->
                                    <!--                        Banner</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                    <!--                        <i class="fa-solid fa-star"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <!--<div class="col-xl-3 col-md-6">-->
                                        <!-- card -->
                                    <!--    <div class="card card-animate"   style="background: #7c1a3e;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark text-truncate mb-0">-->
                                    <!--                        Category</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4">-->
                                    <!--                        <span class="counter-value"-->
                                    <!--                            data-target="{{ $Category }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('category.index') }}"-->
                                    <!--                        class="text-decoration-underline text-dark-50">View-->
                                    <!--                        Category</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                    <!--                        <i class="fa-regular fa-rectangle-list"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
    
    
    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                         <a href="{{ route('product.index') }}"
                                                            class="text-dark-50">
                                        <div class="card card-animate"   style="background: #9caf88;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Product</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="" >{{ $Product }}</span>
                                                        </h4>
                                                       <!--View-->
                                                       <!--     Product-->
                                                    </div>
                                                    <!--<div class="avatar-sm flex-shrink-0">-->
                                                    <!--    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                                    <!--        <i class="fa-solid fa-box-open"></i>-->
                                                    <!--    </span>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div></a>
                                    </div>
    
    
                                    <!--<div class="col-xl-3 col-md-6">-->
                                        <!-- card -->
                                    <!--    <div class="card card-animate"   style="background: #7c1a3e;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark text-truncate mb-0">-->
                                    <!--                        Courier</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span-->
                                    <!--                            class="counter-value" data-target="{{ $Courier }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('courier.index') }}"-->
                                    <!--                        class="text-decoration-underline text-dark-50">-->
                                    <!--                        View Courier</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                    <!--                        <i class="fa-solid fa-users"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
    
                                   
    
                                    
    
    
    
                                    <!--<div class="col-xl-3 col-md-6">-->
                                        <!-- card -->
                                    <!--    <div class="card card-animate"   style="background: #570f29;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark text-truncate mb-0">-->
                                    <!--                        Inquiry</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span-->
                                    <!--                            class="counter-value"-->
                                    <!--                            data-target="{{ $Inquiry }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('Inquiry.index') }}"570f29-->
                                    <!--                        class="text-decoration-underline text-dark-50">-->
                                    <!--                        View Inquiry</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                    <!--                        <i class="fa-solid fa-circle-question"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #b6ae9f;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Today's Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $TodaysOrder }}">0</span>
                                                        </h4>
                                                        <!--<a href="{{ route('Inquiry.index') }}"-->
                                                        <!--    class="text-decoration-underline text-dark-50">-->
                                                        <!--    View Inquiry</a>-->
                                                    </div>
                                                    <!--<div class="avatar-sm flex-shrink-0">-->
                                                    <!--    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                                    <!--        <i class="fa-solid fa-circle-question"></i>-->
                                                    <!--    </span>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                         <a href="{{ route('order.pending') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate"   style="background: #9caf88;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Not Yet Dispatched</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $PendingOrder }}">0</span>
                                                        </h4>
                                                       
                                                            <!--View Pending Order-->
                                                    </div>
                                                    <!--<div class="avatar-sm flex-shrink-0">-->
                                                    <!--    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                                    <!--        <i class="fa-solid fa-clock-rotate-left"></i>-->
                                                    <!--    </span>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div></a>
                                    </div>
                                    
                                    <!--<div class="col-xl-3 col-md-6">-->
                                        <!-- card -->
                                    <!--    <div class="card card-animate"   style="background: #7c1a3e;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark text-truncate mb-0">-->
                                    <!--                        Pending Order Tirupati</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span-->
                                    <!--                            class="counter-value"-->
                                    <!--                            data-target="{{ $PendingOrderTirupati }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('order.tirupati') }}"-->
                                    <!--                        class="text-decoration-underline text-dark-50">-->
                                    <!--                        View Pending Order Tirupati</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                                            <!--<i class="fa-solid fa-circle-question"></i>-->
                                    <!--                        <img style="width: 52px;height: 45px;" src="{{ asset('images/favicon.ico') }}" >-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <!--<div class="col-xl-3 col-md-6">-->
                                        <!-- card -->
                                    <!--    <div class="card card-animate"   style="background: #570f29;">-->
                                    <!--        <div class="card-body">-->
                                    <!--            <div class="d-flex align-items-center">-->
                                    <!--                <div class="flex-grow-1 overflow-hidden">-->
                                    <!--                    <p class="text-uppercase fw-bold text-dark text-truncate mb-0">-->
                                    <!--                        Pending Order Delivery</p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--            <div class="d-flex align-items-end justify-content-between mt-4">-->
                                    <!--                <div>-->
                                    <!--                    <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span-->
                                    <!--                            class="counter-value"-->
                                    <!--                            data-target="{{ $PendingOrderDelivery }}">0</span>-->
                                    <!--                    </h4>-->
                                    <!--                    <a href="{{ route('order.delivery') }}"-->
                                    <!--                        class="text-decoration-underline text-dark-50">-->
                                    <!--                        View Pending Order Delivery</a>-->
                                    <!--                </div>-->
                                    <!--                <div class="avatar-sm flex-shrink-0">-->
                                    <!--                    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                    <!--                        <i class="fa-solid fa-circle-question"></i>-->
                                    <!--                    </span>-->
                                    <!--                </div>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <a href="{{ route('order.dispatched') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate"   style="background: #b6ae9f;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Dispatched Order</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $DispatchedOrder }}">0</span>
                                                        </h4>
                                                        
                                                            <!--View Dispatched Order-->
                                                    </div>
                                                    <!--<div class="avatar-sm flex-shrink-0">-->
                                                    <!--    <span class="avatar-title bg-soft-light rounded fs-3">-->
                                                    <!--        <i class="fa-solid fa-truck-fast"></i>-->
                                                    <!--    </span>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div></a>
                                    </div>
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate" style="background: #9caf88;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Today's Collection</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $TodaysCollection }}">0</span>
                                                        </h4>
                                                        <!--<a href="{{ route('Inquiry.index') }}"-->
                                                        <!--    class="text-decoration-underline text-dark-50">-->
                                                        <!--    View Inquiry</a>-->
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate"  style="background: #b6ae9f;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Stock Value</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $amount }}">{{ $amount }}</span>
                                                        </h4>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate"  style="background: #9caf88;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Stock Quantity</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $stock }}">{{ $stock }}</span>
                                                        </h4>
                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <a href="{{ route('report.orderTracking') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate"  style="background: #b6ae9f;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Order Tracking</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        
                                                        
                                                           <!--View Order Tracking-->
                                                        
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div></a>
                                    </div>
                                    
                                    
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                         <a href="{{ route('report.searchCustomer') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate"  style="background: #9caf88;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Customer Search</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        
                                                       
                                                            <!--View Customer Search-->
                                                        
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div></a>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <a href="{{ route('shoowroom.index') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate" style="background: #b6ae9f;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            View ShowRoom Tracking </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>

                                                        
                                                            <!--View ShowRoom Tracking-->
                                                       

                                                    </div>

                                                </div>
                                            </div>
                                        </div> </a>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                         <a href="{{ route('shoowroom.create') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate" style="background: #9caf88;height: 148px;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Add ShowRoom Tracking </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>

                                                       
                                                            <!--Add ShowRoom Tracking-->
                                                       

                                                    </div>

                                                </div>
                                            </div>
                                        </div> </a>
                                    </div>

                                @else
                                
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                         <a href="{{ route('order.userpending') }}"
                                                            class=" text-dark-50">
                                        <div class="card card-animate"   style="background: #b6ae9f;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-bold text-dark text-truncate mb-0">
                                                            Pending Order Delivery</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-bold ff-secondary text-dark mb-4"><span
                                                                class="counter-value"
                                                                data-target="{{ $PendingOrderDelivery }}">0</span>
                                                        </h4>
                                                       
                                                            <!--View Pending Order Delivery-->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-light rounded fs-3">
                                                            <i class="fa-solid fa-circle-question"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div></a>
                                    </div>
                                
                                @endif        
    
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-center mx-auto">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ env('APP_NAME') }}
                    </div>

                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->


@endsection
