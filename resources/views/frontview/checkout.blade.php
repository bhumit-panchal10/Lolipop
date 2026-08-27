@extends('layouts.front')
@section('title', 'Checkout')
@section('content')

<style>
    .is-invalid {
        border: 1px solid #dc3545 !important;
        background-color: #fff5f5;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 4px;
        display: block;
    }
</style>
    
<form></form>
<form class="form" method="post" action="{{ route('checkoutstore') }}">
    @csrf
    
    <section class="order-summery1 bg-lp p-8">
        <div class="container">
            
                
               
                
           <div class="col-lg-12 p-2"> <h6 class="title showorder">Order Summary &nbsp; &nbsp; <i class="ti-angle-down"></i></h6></div>
            <div class="row">
                
                <div class="col-lg-12 ">
                    <!-- Shopping Summery -->
                    <table class="table order-table" style='<?= Session::has('error') ? "display: table" : "display: none" ?>'>
                        <thead>
                            <tr class="main-hading">
                                <th class="text-left">PRODUCT</th>
                                <th class="text-right">QTY</th>
                                <th class="text-center">SIZE</th>
                                <th class="text-left">PRICE</th>

                                <th class="text-right">TOTAL</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $cartItems = \Cart::getContent();
                                $total = 0; 
                            ?>
                            @foreach ($cartItems as $item)
                                 @php 
                                    $ProductAttribute = App\Models\ProductAttributes::orderBy('id', 'desc')
                                        ->where(["product_id" => $item->productid, 'id' => $item->size])
                                        ->first();
                                    $Ledger = App\Models\Ledger::orderBy('ledgerId', 'desc')->where([
                                            'ledger.iStatus' => 1, 'ledger.isDelete' => 0, 'ledger.iProductId' => $item->productid, 'iSize' => $item->size
                                        ])
                                        ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
                                        ->first();
                                    $closingBalance = (int)$Ledger->closingBalance;
                                @endphp   
                                <tr>
                                    <td class=" text-left" data-title="No"><img
                                            src="{{ asset('Product') . '/' . $item->attributes->image }}" alt="#">
                                            @if($closingBalance <= 0)
                                                <br /><span style="color: red;font-size: xx-small;">Product out of stock</span>
                                            @endif
                                    </td>
                                    <!--<td class="product-des" data-title="Description">-->
                                    <!--    <p class="product-name"><a href="productlisting.php">{{ $item->name }}</a></p>-->
                                    <!--</td>-->
                                    <td class=" text-right" data-title="Qty">
                                        {{ $item->quantity }}&nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td class=" text-center" data-title="Qty">
                                        {{ $ProductAttribute->product_attribute_size }}
                                    </td>
                                    <td class="price text-left" data-title="Price">
                                        <span> &#x20B9; {{ $item->price }}
                                        </span>
                                    </td>

                                    <td class="total-amount text-right" data-title="Total">
                                        <span> &#x20B9; {{ $item->price * $item->quantity }}</span>
                                    </td>

                                </tr>
                                <?php $total += $item->price * $item->quantity; ?>
                            @endforeach

                            <!--<tr>-->
                            <!--    <td class="text-right border-0 " colspan="4">Subtotal</td>-->
                            <!--    <td class="text-right border-0">₹ {{ $total }}</td>-->
                            <!--</tr>-->
                            <!--<tr>-->
                            <!--    <td class="text-right border-0" colspan="4">Shipping</td>-->
                            <!--    <td class="text-right border-0">₹ 0.00</td>-->
                            <!--</tr>-->
                            <tr>
                                <td class="text-right bold border-0" colspan="4">Total Amount</td>
                                <td class="bold text-right border-0">₹ {{ $total }}</td>
                            </tr>

                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
        </div>
    </section>
    
    <section class="shop checkout order-summery1 p-2 border contact-box">
    
    
        <div class="container">
            @include('common.alert')
         <div class="row">
             
             <div class="col-lg-4">
                  <div class="row">
                                     <h6 class="mb-2">Contact</h6>
                                     </div>
            </div>
                <div class="form-group col-lg-4">
                     <div class="row position-relative">
                        <span style=" position: absolute; left: 7px; top: 0px; padding: 10px 30px 9px 9px;"> +91 </span>
                        <input class="@error('billPhone') is-invalid @enderror d-inline" type="text" name="billPhone" id="billPhone" onkeydown="checkcustomer();"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            maxlength="10" minlength="10" placeholder="Phone Number *" required="required"
                            autocomplete="off" value="{{ old('billPhone') }}" style="margin:0 7px;padding-left:45px">
                        @error('billPhone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>       
                     <div class="row mt-2  position-relative">
                        <span style=" position: absolute; left: 7px; top: 0px; padding: 10px 30px 9px 9px;"> +91 </span>
                        <input type="text" name="billPhone1" id="billPhone1" 
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            maxlength="10" minlength="10" placeholder="Phone Number Additional" 
                            autocomplete="off" value="{{ old('billPhone1') }}" style="margin:0 7px;padding-left:45px">    
                     </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shop checkout section">
        <div class="container">
            
            <div class="row">
                <div class="col-lg-8 col-12">
                   
                    
                    <div class="checkout-form">
                        <h2>Shipping Information</h2>

                        <div class="row">
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>First Name<span>*</span></label>-->
                                    <input class="@error('billFirstName') is-invalid @enderror" type="text" name="billFirstName" id="billFirstName" placeholder="First Name *"
                                        required="required" autocomplete="off" value="{{ old('billFirstName') }}">
                                    @error('billFirstName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Last Name<span>*</span></label>-->
                                    <input type="text" class="@error('billLastName') is-invalid @enderror" name="billLastName" id="billLastName" placeholder="Last Name *"
                                        required="required" autocomplete="off" value="{{ old('billLastName') }}">
                                    @error('billLastName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Email Address<span>*</span></label>-->
                                    <input type="email" name="billEmail" id="billEmail" placeholder="Email Address *"
                                         autocomplete="off" value="{{ old('billEmail') }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Address Line 1<span>*</span></label>-->
                                    <input class="@error('billStreetAddress1') is-invalid @enderror" type="text" name="billStreetAddress1" id="billStreetAddress1" placeholder="Address Line 1 *"
                                        required="required" autocomplete="off" value="{{ old('billStreetAddress1') }}">
                                    @error('billStreetAddress1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Address Line 2<span>*</span></label>-->
                                    <input class="@error('billStreetAddress2') is-invalid @enderror" type="text" name="billStreetAddress2" id="billStreetAddress2" placeholder="Address Line 2 *"
                                        required="required" autocomplete="off" value="{{ old('billStreetAddress2') }}">
                                    @error('billStreetAddress2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>State <span>*</span></label>-->
                                    <select class="@error('billState') is-invalid @enderror" name="billState" id="state_province" autocomplete="off">
                                        <option value="">Select state</option>
                                        @foreach ($State as $state)
                                        <option value="{{ $state->stateId }}" {{ old('billState')==$state->stateId ?
                                            'selected' : '' }}>
                                            {{ $state->stateName }}</option>
                                        @endforeach
                                    </select>
                                    @error('billState')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Country<span>*</span></label>-->
                                    <input class="@error('shipping_city') is-invalid @enderror" type="text" name="shipping_city" id="shipping_city"
                                         placeholder="Enter City *" required="required"  value="{{ old('shipping_city') }}">
                                    @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Country<span>*</span></label>-->
                                    <input class="@error('strCountry') is-invalid @enderror" type="text" name="strCountry" id="strCountry"
                                         placeholder="Country *" required="required" readonly
                                        value="India">
                                    @error('strCountry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <!--<label>Postal Code<span>*</span></label>-->
                                    <input class="@error('billPinCode') is-invalid @enderror" type="text" name="billPinCode" id="billPinCode"
                                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                        minlength="6" maxlength="6" placeholder="Postal Code *" required="required"
                                        value="{{ old('billPinCode') }}">
                                    @error('billPinCode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror    
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2 class="text-center">CART TOTAL</h2>
                            <div class="content">
                                <ul>
                                    @php
                                    $Total = \Cart::getTotal();
                                    @endphp
                                    <li>Sub Total<span>&#x20B9; {{ $Total }}</span></li>
                                    <li>Shipping Free<span> - &nbsp; &nbsp;</span></li>
                                    <li class="last bold">Total<span>&#x20B9; {{ $Total }}</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="single-widget payement">
                            <div class="content">
                                <img src="{{ asset('assets/front/images/payment-method.png') }}" alt="#">
                            </div>
                        </div>

                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <a href="#">
                                        <button class="btn" type="submit">
                                            Pay Now
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--/ End Button Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Checkout -->
</form>




@endsection

@section('scripts')

<script>
function checkcustomer(){

    var phone = $('#billPhone').val();
    var url = "{{ route('checkmobile') }}";
    
    if(phone.length == 10){
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                phone: phone,
            },
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                $('#billFirstName').val(obj.firstname);
                $('#billLastName').val(obj.lastname);
                $('#billEmail').val(obj.customeremail);
                $('#billStreetAddress1').val(obj.address);
                $('#billStreetAddress2').val(obj.address1);
                
                $('#state_province').val(obj.state);
                
                $('#shipping_city').val(obj.city);
                // $('#strCountry').val(obj.country);
                $('#billPinCode').val(obj.pincode);
            }
        });
    }
}
</script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(".showorder").click(function(){
  $(".order-table").toggle();
});</script>

@endsection