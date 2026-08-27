@extends('layouts.front')
@section('title', 'Payment')
@section('content')


<style>
    .ship-head{
            padding: 6px;
    background: #603813;
    color: white;
    font-size: 16px;
    text-transform: uppercase;

    }
    
    .ship-inp{
        border:none;
        margin-bottom:0px;
        width:100%;
    }
    
    .b-none{
        border:none !important;
    }
</style>

    <script>
        window.onload = function() {
            var d = new Date().getTime();
            document.getElementById("tid").value = d;
        };
    </script>
    
     	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" 
	    style="background-image: url({{ asset('assets/frontimages/catagory/SHOP.jpg') }});">
		<h2 class="ltext-105 cl0 txt-center">
		   Payment
		</h2>
	</section>	



    <!--<form class="mt-5" method="post" name="customerData" action="{{ route('ccavRequestHandler') }}">-->
    <form class="mt-5" method="post" name="customerData" action="https://www.mbherbals.com/ccavRequestHandler.php">
        @csrf
        
        <input type="hidden" name="tid" id="tid" readonly />
        <input type="hidden" name="merchant_id" value="247741" />
        <input type="hidden" name="order_id" value="{{ $OrderId }}" />
        <input type="hidden" name="redirect_url" value="https://www.mbherbals.com/ccavResponseHandler.php" />
        <input type="hidden" name="cancel_url" value="https://www.mbherbals.com/ccavResponseHandler.php" />
        <input type="hidden" name="language" value="EN" />
        <input type="hidden" name="billing_address"
            value="{{ $Order['shiiping_address1'] . ',' . $Order['shiiping_address2'] }}" />
        <input type="hidden" name="billing_city" value="{{ $Order['shipping_city'] }}" />
        <input type="hidden" name="billing_state" value="{{ $Order['stateName'] }}" />
        <input type="hidden" name="billing_zip" value="{{ $Order['shipping_pincode'] }}" />
        <input type="hidden" name="billing_country" value="India" />

        <table width="40%" class="mx-auto" height="100" border='1' align="center">

            <tr>
                <td class="ship-head" colspan="2">Shipping information :</td>
            </tr>
            <tr>
                <td style="width: 30%;">Shipping Name :</td>
                <td><input class="ship-inp" type="text" name="billing_name" value="{{ $Order['shipping_cutomerName'] }}" /></td>
            </tr>
            <tr>
                <td>Shipping Address :</td>
                <td>
                    <?php $address = trim($Order['shiiping_address1']); ?>
                    <div class="ship-inp" name="full_address" id="full_address" cols="30" rows="7">
                        {{ $address . ',' . $Order['shipping_city'] . ',' . $Order['shiiping_state'] . ',' . $Order['shipping_pincode'] }}
                    </div>
                </td>
            </tr>

            <tr>
                <td>Shipping Tel :</td>
                <td><input class="ship-inp" type="text" name="billing_tel" value="{{ $Order['shipping_mobile'] }}" /></td>
            </tr>

            <tr>
                <td>Shipping Email :</td>
                <td><input class="ship-inp" type="text" name="billing_email" value="{{ $Order['shipping_email'] }}" /></td>
            </tr>

            <tr>
                <td>Amount :</td>
                <td><input class="ship-inp" type="text" name="amount" value="{{ $Order['netAmount'] }}" readonly /></td>
            </tr>
            <tr>
                <td>Currency :</td>
                <td><input class="ship-inp" type="text" name="currency" value="INR" /></td>
            </tr>
            
             
        </table>
        <table  width="40%" class="mx-auto  mb-5" height="100" border='1' align="center">
             <tr class="">
                
                <td  class="b-none"><INPUT class="flex-c-m stext-101 cl0 size-116 bg3  hov-btn3 p-lr-15 trans-04 pointer mb-0"  type="submit" value="PAY NOW">
                </td>
                <td class="b-none"> <a class="flex-c-m stext-101 cl0 size-116 bg3  hov-btn3 p-lr-15 trans-04 pointer"
                        href="{{ route('FrontIndex') }}">Cancel</a></td>
            
            </tr>
              
        </table>
@endsection    