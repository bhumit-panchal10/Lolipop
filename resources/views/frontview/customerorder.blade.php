@extends('layouts.front')
@section('title', 'Checkout')
@section('content')

<form></form>
<form class="form" method="post" action="{{ route('checkoutstore') }}">
    @csrf
    
    <section class="order-summery1 bg-lp p-8">
        <div class="container">
            
           <div class="row">
                <div class="col-lg-12 ">
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery  table-responsive bg-lp" >
                        <thead>
                            <tr class="main-hading">
                                <th>PRODUCT</th>
                                <th class="text-right">QTY</th>
                                <th class="text-center">SIZE</th>
                                <th class="text-left">PRICE</th>

                                <th class="text-right">TOTAL</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                               
                                $total = 0; 
                            ?>
                            @foreach ($Order as $order)
                             @php 
                                    $ProductAttribute = App\Models\ProductAttributes::orderBy('id', 'desc')
                                        ->where(["product_id" => $order->productId, 'id' => $order->size])
                                        ->first();
                                @endphp 
                                   
                                <tr>
                                    <td class=" text-left" ><img
                                            src="{{ asset('Product') . '/' . $order->photo }}" alt="#">
                                    </td>
                                    <td class=" text-right" >
                                        {{ $order->quantity }}&nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td class=" text-center" >
                                        {{ $ProductAttribute->product_attribute_size }}
                                    </td>
                                    <td class="price text-left" >
                                        <span> &#x20B9; {{ $order->rate }}
                                        </span>
                                    </td>

                                    <td class="total-amount text-right" >
                                        <span> &#x20B9; {{ $order->rate * $order->quantity }}</span>
                                    </td>

                                </tr>
                                <?php $total += $order->rate * $order->quantity; ?>
                            @endforeach

                            <tr>
                                <td class="text-right bold border-0 bg-white" style="margin-top:10px" colspan="4">Total Amount</td>
                                <td class="bold text-right border-0 bg-white mt-2" style="margin-top:10px">₹ {{ $total }}</td>
                            </tr>

                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>     
               
        </div>
    </section>
   
    <section class="shop checkout section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Your Order No : {{ $ORDER_ID }} </h2>
                        <h2>Shipping Information</h2>

                        <div class="row">
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ $Total->shipping_cutomerName }}</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{$Total->shipping_email }}</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{$Total->shipping_mobile }}</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{$Total->shiiping_address1}}</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                   <label>{{$Total->shiiping_address2}}</label>
                                </div>
                            </div>
                                
                            <?php 
                                $State = App\Models\State::where(['stateId'=>$Total->shiiping_state])->first();
                                // dd($State);
                            ?>    
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{$State->stateName}}</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{$Total->shipping_city}}</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{$Total->country}}</label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                   <label>{{$Total->shipping_pincode}}</label>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <!--<div class="col-lg-4 col-12">-->
                <!--    <div class="order-details">-->
                        <!-- Order Widget -->
                <!--        <div class="single-widget">-->
                <!--            <h2 class="text-center">CART TOTAL</h2>-->
                <!--            <div class="content">-->
                <!--                <ul>-->
                                    
                <!--                    <li>Sub Total<span>&#x20B9; {{ $Total->netAmount }}</span></li>-->
                <!--                    <li>Shipping Free<span> - &nbsp; &nbsp;</span></li>-->
                <!--                    <li class="last bold">Total<span>&#x20B9; {{ $Total->netAmount }}</span></li>-->
                <!--                </ul>-->
                <!--            </div>-->
                <!--        </div>-->

                <!--        <div class="single-widget payement">-->
                <!--            <div class="content">-->
                <!--                <img src="{{ asset('assets/front/images/payment-method.png') }}" alt="#">-->
                <!--            </div>-->
                <!--        </div>-->

                       
                        <!--/ End Button Widget -->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </section>
    <!--/ End Checkout -->
</form>




@endsection

