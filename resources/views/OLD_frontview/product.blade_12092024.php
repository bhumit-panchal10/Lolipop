@extends('layouts.front')
@section('title', 'Product')
@section('content')
    @include('common.front.frontalert')

    <!-- Start Product Area -->

    <div class="product-area  most-popular section">
        <div class="container-fluid">

            <?php if($ProductCount > 0){ ?>
            <!--<div class="row">-->
            <!--    <div class="col-12">-->
            <!--        <div class="section-title">-->
            <!--            <h2>New Arrivals</h2>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <?php } ?>

            <div class="row">
                <?php if($ProductCount == 0){ ?>
                <div class="col-md-12 col-sm-6">
                    <h2 class="text-center">No data Found!</h2>
                </div>
                <?php }else{ ?>
                @foreach ($Product as $product)
                    <div class="col-lg-3 col-sm-6">
                        <div class="product-grid mb-2">
                            <div class="product-image">
                                <a href="{{ route('productdetail', $product->slugname) }}" class="image">
                                    <img class="img-1" src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}">
                                </a>
                                @if($product->closingBalance <= 0)
                                    <div class="outofstock">OUT OF STOCK</div>
                                @endif    
                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a href="{{ route('productdetail', $product->slugname) }}">{{ $product->productname }}
                                    </a>
                                </h3>
                                <div class="price"> ₹ {{ $product->product_attribute_price }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <?php } ?>

            </div>

            <!--<div class="d-flex justify-content-center mt-3 pg-links">-->
            <!--    {{ $Product->appends(request()->except('page'))->links() }}-->
            <!--</div>-->
            
              <div class="d-flex justify-content-center mt-3">
                <button class="btn" id="show-more">Show More</button>
            </div>


        </div>

    </div>
    <!-- End Product Area -->
    
    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="owl-carousel home-slider-4">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-truck"></i>
						<h4>Free Domestic Shipping</h4>
						<p> Shipping Worldwide</p>
						<!--<p>Orders over &#x20B9;  100</p>-->
					</div>
					<!-- End Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% Secure Payment</p>
					</div>
				
					<div class="single-service noborder">
						<i class="ti-tag"></i>
						<h4>Best price</h4>
						<p>Guaranteed Price</p>
					</div>
						<div class="single-service">
						<i class=" ti-gift"></i>
						<h4>HANDCRAFTED WITH LOVE</h4>
						
						<!--<p>Within 30 days returns</p>-->
					</div>
					<!-- Start Single Service -->
					<div class="single-service">
						<!--<h4>X</h4>-->
						<i class="ti-na"></i>
						
						
						<h4>No Return </h4>
						<h4>No Refund </h4>
						<h4>No Exchange </h4>
						<!--<p>Within 30 days returns</p>-->
					</div>
					<!-- End Single Service -->
				
					<!-- Start Single Service -->
					<!-- End Single Service -->
			
					<!-- Start Single Service -->
					<!-- End Single Service -->

</div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->
@endsection

@section('scripts')
    <script>
    $(document).ready(function(){
        var page = 2; // Initial page number for loading more products
        $('#show-more').click(function(){
            $.ajax({
                url: '{{ route('loadMoreProducts') }}', // Adjust this route according to your backend logic
                method: 'get',
                data: { page: page },
                success: function(response){
                    if(response.products.length > 0){
                        // Append new products to the existing ones
                        response.products.forEach(function(product){
                            var productHtml = `<div class="col-lg-3 col-sm-6">
                                                    <div class="product-grid mb-2">
                                                        <div class="product-image">
                                                            <a href="{{ route('productdetail') }}/${product.slugname}" class="image">
                                                                <img class="img-1" src="{{ asset('Product/Thumbnail/') }}/${product.photo}">
                                                            </a>`;
                                                             if(product.closingBalance <= 0){
                                    productHtml += `<div class="outofstock">OUT OF STOCK</div>`;
                                }
                                 
                                                        productHtml += `<div class="product-content">
                                                            <h3 class="title">
                                                                <a href="{{ route('productdetail') }}/${product.slugname}">${product.productname}</a>
                                                            </h3>
                                                            <div class="price"> ₹ ${product.product_attribute_price}</div>
                                                        </div>
                                                    </div>
                                                </div>`;
                            $('.product-area .row').append(productHtml);
                        });
                        page++; // Increment the page number for the next request
                    } else {
                        // No more products to load
                        $('#show-more').prop('disabled', true).text('No more products');
                    }
                }
            });
        });
    });
</script>
@endsection
