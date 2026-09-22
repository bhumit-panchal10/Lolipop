@extends('layouts.front')
@section('title', 'My Order Detail')
@section('content')

    <section class="order-detail section">

        <div class="container">

            <div class="profile-container row">
                <div class="col-lg-3">
                    <ul class="left">
                        <li><a href="user-profile.php">Dashboard</a></li>

                        <li><a href="my-order.php">My Order</a></li>
                        <li><a href="order-detail.php">Order History</a></li>
                        <li><a href="changepassword.php">change Password</a></li>
                        <li><a href="productlisting.php">Shop</a></li>

                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <!-- Shopping Summery -->
                            <table class="table shopping-summery table-bordered">
                                <thead>
                                    <tr class="main-hading">
                                        <th>PRODUCT</th>
                                        <th class="text-left">NAME</th>
                                        <th class="text-center">QUANTITY</th>
                                        <th class="text-right">PRICE</th>

                                        <th class="text-right">TOTAL</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="image" data-title="No"><img src="images/pr-2.jpg" alt="#"></td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="productlisting.php">Dark Green Dress</a></p>
                                            <p class="product-des">Product Delivery by 05/02/2024</p>
                                        </td>
                                        <td class="qty text-center" data-title="Qty">

                                            1

                                        </td>
                                        <td class="price text-right" data-title="Price"><span> &#x20B9; 869.00 </span></td>

                                        <td class="total-amount text-right" data-title="Total"><span> &#x20B9; 869.00</span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="image" data-title="No"><img src="images/pr-5.jpg" alt="#"></td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="productlisting.php">Orange Dress</a></p>
                                            <p class="product-des">Product Delivery by 05/02/2024</p>
                                        </td>
                                        <td class="qty text-center" data-title="Qty">
                                            1

                                        </td>
                                        <td class="price text-right" data-title="Price"><span> &#x20B9; 1149.00 </span></td>

                                        <td class="total-amount text-right" data-title="Total"><span> &#x20B9;
                                                1149.00</span></td>

                                    </tr>
                                    <tr>
                                        <td class="image" data-title="No"><img src="images/pr-1.jpg" alt="#"></td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="productlisting.php">White floral top with
                                                    dupatta</a></p>
                                            <p class="product-des">Product Delivery by 05/02/2024</p>
                                        </td>
                                        <td class="qty text-center" data-title="Qty">
                                            1

                                        </td>
                                        <td class="price text-right" data-title="Price"><span> &#x20B9; 2110.00 </span></td>

                                        <td class="total-amount text-right" data-title="Total"><span> &#x20B9;
                                                2110.00</span></td>

                                    </tr>
                                    <tr>
                                        <td class="text-right " colspan="4">Subtotal</td>
                                        <td class="text-right">₹ 4128.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right " colspan="4">Shipping</td>
                                        <td class="text-right">₹ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right bold" colspan="4">Total Ammount</td>
                                        <td class="bold text-right">₹ 4128.00</td>
                                    </tr>

                                </tbody>
                            </table>
                            <!--/ End Shopping Summery -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection

@section('scripts')
    <script>
        function getpopupdata(id) {
            var ID = id;
            var url = "{{ route('productpopupview', ':id') }}";
            url = url.replace(":id", ID);
            if (ID) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: ID
                    },
                    success: function(data) {
                        console.log(data);
                        $('#dataplacehere').html(data);
                    }
                });
            }
        }
    </script>
@endsection
