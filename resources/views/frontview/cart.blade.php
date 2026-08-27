@extends('layouts.front')
@section('title', 'Cart')
@section('content')

    @include('common.front.frontalert')

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
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
                            <?php $total = 0; ?>
                            @foreach ($cartItems as $item)
                                 @php 
                                    $ProductAttribute = App\Models\ProductAttributes::orderBy('id', 'desc')
                                        ->where(["product_id" => $item->productid, 'id' => $item->size])
                                        ->first();
                                @endphp   
                                <tr>
                                    <td class="image" data-title="No"><img
                                            src="{{ asset('Product') . '/' . $item->attributes->image }}" alt="#">
                                    </td>
                                    <!--<td class="product-des" data-title="Description">-->
                                    <!--    <p class="product-name"><a href="productlisting.php">{{ $item->name }}</a></p>-->
                                    <!--</td>-->
                                    <td class="qty text-right" data-title="Qty">
                                        {{ $item->quantity }}&nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td class="qty text-center" data-title="Qty">
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
                                <td class="text-right bold border-0 bg-white" style="margin-top:10px" colspan="4">Total Amount</td>
                                <td class="bold text-right border-0 bg-white mt-2" style="margin-top:10px">₹ {{ $total }}</td>
                            </tr>

                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <?php $total = Cart::getTotal(); ?>
                                        <!--<form action="{{ route('couponcodeapply') }}" method="post">-->
                                        <!--    @csrf-->
                                        <!--    <input type="hidden" value="{{ $total }}" name="totalAmount">-->
                                        <!--    <input name="coupon" placeholder="Enter Your Coupon">-->
                                        <!--    <button type="submit" class="btn">Apply</button>-->
                                        <!--</form>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <!--<li>Cart Total<span>&#x20B9; {{ $total }}</span></li>-->

                                       

                                        <!--<li>Shipping Free<span class=""> -  &nbsp; &nbsp;</span></li>-->
                                        <!--<li>You Save<span>&#x20B9; 200.00</span></li>-->
                                        <!--<li class="last">You Pay<span>&#x20B9; {{ $total }}</span></li>-->
                                    </ul>
                                    <div class="button5 pt-5">
                                        <a href="{{ route('checkout') }}" class="btn">Checkout</a>
                                        <a href="{{ route('FrontProduct') }}" class="btn">Continue shopping</a></br></br></br></br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

   

@endsection

@section('scripts')

    <script>
        function increaseCount(a, b) {
            var input = b.previousElementSibling;
            var value = parseInt(input.value, 10);
            value = isNaN(value) ? 0 : value;
            {{--  value++;  --}}
            input.value = value;
        }

        function decreaseCount(a, b) {
            var input = b.nextElementSibling;
            var value = parseInt(input.value, 10);
            // alert(value);
            if (value > 1) {
                value = isNaN(value) ? 0 : value;
                {{--  value--;  --}}
                input.value = value;
            }
        }
    </script>

@endsection
