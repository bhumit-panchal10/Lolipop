@extends('layouts.front')
@section('title', 'My Orders')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .pagination-t nav ul {
        display: flex;
    }
    .page-item.active .page-link {
        z-index: 2;
        color: #fff;
        background-color: #9a7c6f;
        border-color: #9a7c6f;
    }
    .btnn {
        
        /*width: 62px;*/
        text-align: center;
        font-size: 18px;
        color: #fff;
        background: #9a7c6f;
        position: relative;
        /*top: -1px;*/
        border: none;
        border-radius: 5px;
        transition: all 0.4s ease;
        padding:8px 15px;
    }
    .form-control::placeholder {
  color: #9a7c6f; /* your desired color */
  opacity: 1;  /* remove default transparency */
}
    @media only screen and (max-width: 600px){
   .header.shop .topbar .top-left{display:none;}
    .header.shop .topbar .right-content ul{display:flex;        justify-content: space-between;}
     
        .profile-container .left{display:none!important;}
    .header.shop .list-main li{
        border-bottom:0;
    }
    .header.shop .topbar .right-content{border-top:0;}
   
    }
    .footer{display:none;}
    .header.shop .right-bar{display:none;}
    .view-order-txt{position:relative;}
 .view-order-txt::after {
    content: "";
    position: absolute;
    bottom: 0px;
    background: blue;
    width: 100%;
    height: 2px;
    left: 0;
}
</style>

<section class="shop checkout section">
    <div class="container">
        <div class="profile-container row">
            {{-- Sidebar --}}
            <div class="col-lg-3">
                <ul class="left">
                    <li><a href="{{ route('myaccount') }}">Dashboard</a></li>
                    <li><a class="active" href="{{ route('myorders') }}">My Orders</a></li>
                    <li><a href="{{ route('FrontIndex') }}">Shop</a></li>
                </ul>
            </div>

            {{-- Orders --}}
            <div class="order-history py-3 col-lg-9">
                <h4 class="text-center">Track Your Order</h4><br>

                {{-- Search Form --}}
                <section class="shop checkout order-summery1 p-2  contact-box">
                    <div class="container">
                        @include('common.alert')
                        <div class="row pb-5">
                            <form method="post" action="{{ route('myorders') }}" class="d-flex flex-wrap w-100">
                                @csrf
                                <div class="form-group col-lg-4 mb-2 p-0">
                                    <input type="text"
                                           name="order_id"
                                           id="order_id"
                                           class="form-control text-center"
                                           placeholder=" Order No"
                                           value=""
                                           autocomplete="off"
                                           style="padding-left:20px;">
                                </div>
                                <p class="mx-2 mb-2 text-center d-block w-100">OR</p>
                                <div class="form-group col-lg-4 mb-2 position-relative p-0">
                                    <span style="position:absolute; left:7px; top:0; padding:10px 30px 9px 9px;">+91</span>
                                    <input type="text"
                                           name="phone_no"
                                           id="phone_no"
                                           class="form-control text-center"
                                           maxlength="10"
                                           minlength="10"
                                           placeholder="Mobile Number"
                                           autocomplete="off"
                                           value="{{ request('phone_no') }}"
                                           style="padding-left:45px;"
                                           onkeyup="if(/\D/g.test(this.value)) this.value=this.value.replace(/\D/g,'')">
                                </div>
                                <div class="form-group col-lg-4 mb-5 position-relative pb-5 mt-3 text-center">
                                    <button class="btnn" type="submit"> Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                {{-- Orders Table --}}
                @if(request()->has('order_id') || request()->has('phone_no'))
                    @if($Order->count() > 0)
                        <table class="table table-bordered mt-4 text-center" style="margin-top:50px!important">
                            <thead>
                                <tr>
                                    <!--<th>Order ID</th>-->
                                    <th class="text-white text-center fw-bold" colspan="2">Detail for Order No : {{ request('order_id') }}</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Order as $order)
                                
                                    @php
                                        $Courier = App\Models\Courier::where([
                                            'iStatus' => 1,
                                            'isDelete' => 0,
                                            'id' => $order->courier
                                        ])->first();
                                
                                         $urlToClient = $Courier ? 
                                        ($order->courier == 1 || $order->courier == 4
                                            ? $Courier->url 
                                            : $Courier->url . $order->docketNo
                                        ) 
                                        : '';
                                    @endphp
                                    
                                    <tr>
                                        <!--<td>{{ 'Order_' . $order->order_id }}</td>-->
                                        <td>
                                            <a target="_blank" href="{{ route('customerorder',[$order->order_id , $Customer->guid]) }}" class="view-order-txt">
                                                View Order
                                            </a>
                                        </td>
                                        
                                        <td>
                                            @if($order->docketNo)
                                                <a target="_blank" href="{{ $urlToClient }}">
                                                    Track Order
                                                </a>
                                                @if ($order->courier == 1 || $order->courier == 4) 
                                                    <br>
                                                    <a target="_blank" href="{{ $urlToClient }}" style="text-decoration:underline">
                                                    Visit Link : {{ $urlToClient }}
                                                    </a>
                                                    <br>
                                                    Your Awb No : {{ $order->docketNo }} <a href="javascript:void(0)"
                                                       class="ms-1"
                                                       data-copy="{{ $order->docketNo }}"
                                                       onclick="copyFromAttr(this)"
                                                       title="Copy to clipboard">
                                                        <i class="fa fa-copy"></i>
                                                    </a>
                                                @endif    
                                            @else
                                                Your parcel will be dispatched soon
                                            @endif    
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        
                    @else
                        <div class="alert alert-info mt-4 text-center">No orders found for your search.</div>
                    @endif
                @else
                    <!--<div class="alert alert-secondary mt-4 text-center">-->
                    <!--    Please enter Order ID or Phone Number to track your order.-->
                    <!--</div>-->
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Order Details Modal --}}
<div id="orderModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table shopping-summery table-bordered">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th class="text-left">NAME</th>
                                        <th class="text-center">SIZE</th>
                                        <th class="text-center">QUANTITY</th>
                                        <th class="text-right">PRICE</th>
                                        <th class="text-right">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody class="shopping-summery tbody"></tbody>
                            </table>

                            <div class="text-right font-weight-bold mt-2">
                                Total Amount : ₹ <span id="maintotal"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function getEditData(id) {
        const url = "{{ route('myordersdetails', ':id') }}".replace(":id", id);
        if (id) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (orders) {
                    let html = '';
                    let totalAmount = 0;

                    orders.forEach(order => {
                        html += `
                            <tr>
                                <td class="image" data-title="No"><img src="/Product/${order.photo}" alt="#" width="60"></td>
                                <td class="product-des"><p class="product-name"><a href="#">${order.productname}</a></p></td>
                                <td class="qty text-center">${order.size}</td>
                                <td class="qty text-center">${order.quantity}</td>
                                <td class="price text-right">&#x20B9;${order.rate}</td>
                                <td class="total-amount text-right">&#x20B9;${order.amount}</td>
                            </tr>`;
                        totalAmount += parseFloat(order.amount);
                    });

                    $('#maintotal').text(totalAmount.toFixed(2));
                    $('.shopping-summery tbody').html(html);
                },
                error: function (xhr) {
                    console.error('Error fetching order details:', xhr);
                }
            });
        }
    }
</script>

<script>
    function copyFromAttr(el) {
        const text = el.getAttribute('data-copy');

        if (!navigator.clipboard) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            return;
        }

        navigator.clipboard.writeText(text);
    }
</script>


@endsection
