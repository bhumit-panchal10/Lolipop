@extends('layouts.front')
@section('title', 'Category')
@section('content')
    @include('common.front.frontalert')

    <!-- Start Product Area -->

    <div class="product-area  most-popular section">
        <div class="container-fluid">
            
            <input type="hidden" name="categoryid" id="categoryid" value={{ $id }}>

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
                                <ul class="product-links">
                                    <li>
                                        <!--<a href="{{ route('productdetail', $product->slugname) }}">-->
                                        <!--    <i class="fa fa-shopping-cart"></i>-->
                                        <!--</a>-->
                                    </li>
                                </ul>
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

        </div>
        <div class="d-flex justify-content-center mt-3 pg-links pagination">
        {{ $Product->appends(request()->except('page'))->links() }}
    </div>
    </div>
    
    <!-- <div class="d-flex justify-content-center mt-3">-->
    <!--    <button class="btn" id="show-more">Show More</button>-->
    <!--</div>-->

    <!-- End Product Area -->
@endsection

@section('scripts')
    <script>
    $(document).ready(function(){
        var page = 2; // Initial page number for loading more products
        var categoryid = $("#categoryid").val();
        $('#show-more').click(function(){
            $.ajax({
                url: '{{ route('loadMoreCategoryProducts') }}',
                method: 'get',
                data: { 
                    page: page ,
                    categoryid : categoryid,
                    },
                success: function(response){
                    if(response.products.length > 0){
                        // Append new products to the existing ones
                        response.products.forEach(function(product){
                            var productHtml = `<div class="col-lg-3 col-sm-6">
                                                    <div class="product-grid mb-2">
                                                        <div class="product-image">
                                                            <a href="{{ route('productdetail') }}/${product.slugname}" class="image">
                                                                <img class="img-1" src="{{ asset('Product/Thumbnail/') }}/${product.photo}">
                                                            </a>
                                                            <ul class="product-links">
                                                                <li>
                                                                <!--<a href="{{ route('productdetail') }}/${product.slugname}">-->
                                                                        <!--<i class="fa fa-shopping-cart"></i>-->
                                                                    <!--</a>-->
                                                                <!--</li>-->
                                                            </ul>
                                                        </div>
                                                        <div class="product-content">
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
