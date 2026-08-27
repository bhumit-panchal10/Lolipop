@extends('layouts.front')
@section('title', 'Shop')
@section('content')
    @include('common.frontalert')

    <!-- Product Detail -->
        <section class="sec-product-detail bg0 p-t-65 p-b-60 sec-mt50">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                <div class="slick3 gallery-lb">
                                    @foreach ($Photos as $photos)
                                        <div class="item-slick3"
                                            data-thumb="{{ asset('Product/Thumbnail/') . '/' . $photos->strphoto }}">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="{{ asset('Product/Thumbnail/') . '/' . $photos->strphoto }}"
                                                    alt="IMG-PRODUCT">

                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="{{ asset('Product/') . '/' . $photos->strphoto }}">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                            <h1 class="mtext-105 cl2 js-name-detail p-b-14">
                                {{ $ProductDetail->productname }}
                            </h1>

                            <span class="mtext-106 cl2">
                                ₹{{ $ProductDetail->rate }}
                            </span>

                            <ul class="pro-detail-t">
                                <li>
                                    {!! $ProductDetail->description !!}
                                </li>
                            </ul>

                            <!--  -->
                            <div class="p-t-33">

                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">

                                        <?php if($ProductDetail->isStock == 1){ ?>
                                        <form action="{{ route('cart.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                <div onclick='decreaseCount(event, this)'
                                                    class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="num-product" value="1">

                                                <div onclick='increaseCount(event, this)'
                                                    class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>

                                            <input type="hidden" value="1" name="quantity" id="quantity">
                                            <input type="hidden" value="{{ $ProductDetail->productId }}" name="productid">
                                            <input type="hidden" value="{{ $ProductDetail->productname }}"
                                                name="productname">
                                            <input type="hidden" value="{{ $ProductDetail->rate }}" name="price">
                                            <input type="hidden" value="{{ $ProductDetail->weight }}" name="weight">
                                            <input type="hidden" value="{{ $ProductDetail->photo }}" name="image">

                                            <button
                                                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                Add to cart
                                            </button>
                                        </form>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <!--  -->
                            <!--<div class="flex-w flex-m p-l-100 p-t-40 respon7">-->
                            <!--    <div class="flex-m bor9 p-r-10 m-r-11">-->
                            <!--        <a href="#"-->
                            <!--            class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"-->
                            <!--            data-tooltip="Add to Wishlist">-->
                            <!--            <i class="zmdi zmdi-favorite"></i>-->
                            <!--        </a>-->
                            <!--    </div>-->

                            <!--    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"-->
                            <!--        data-tooltip="Facebook">-->
                            <!--        <i class="fa fa-facebook"></i>-->
                            <!--    </a>-->

                            <!--    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"-->
                            <!--        data-tooltip="Twitter">-->
                            <!--        <i class="fa fa-twitter"></i>-->
                            <!--    </a>-->

                            <!--    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"-->
                            <!--        data-tooltip="Google Plus">-->
                            <!--        <i class="fa fa-google-plus"></i>-->
                            <!--    </a>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>


            </div>


        </section>

         <!-- Related Products -->
        <section class="sec-relate-product bg0 p-t-45 p-b-105">
            <div class="container">
                <div class="p-b-45">
                    <h3 class="ltext-106 cl5 txt-center">
                        Related Products
                    </h3>
                </div>

                <!-- Slide2 -->
                <div class="wrap-slick2">
                    <div class="slick2">

                        @foreach ($RelatedProduct as $product)
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <div class="product-grid2">
                                    <div class="product-image2">
                                        <a href="{{ route('productdetail', $product->slugname) }}">
                                            <img class="pic-1"
                                                src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}">
                                                
                                                 <?php if($product->backphoto){ ?>
                                                    <img class="pic-2" src="{{ asset('Product/Thumbnail/') . '/' . $product->backphoto }}">
                                                <?php }else{ ?>
                                                    <img class="pic-2" src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}">
                                                <?php } ?>
                                                
                                            <!--<img class="pic-2"-->
                                            <!--    src="{{ asset('Product/Thumbnail/') . '/' . $product->backphoto }}">-->
                                        </a>

                                        <ul class="social">
                                            <li>
                                                <a href="#" class="js-show-modal1"
                                                    onclick="getpopupdata(<?= $product->productId ?>)"
                                                    data-tip="Quick View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('wishlist') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $product->productId }}" name="productid">
                                                    <button class="text-white" type="submit">
                                                        <a href="#" data-tip="Add to Wishlist">
                                                            <i class="fa fa-heart"></i>
                                                        </a>
                                                    </button>
                                                </form>
                                            </li>
                                            
                                        </ul>
                                        <?php if($product->isStock == 1){ ?>
                                        <form action="{{ route('cart.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="1" name="quantity">
                                            <input type="hidden" value="{{ $product->productId }}" name="productid">
                                            <input type="hidden" value="{{ $product->productname }}"
                                                name="productname">
                                            <input type="hidden" value="{{ $product->rate }}" name="price">
                                            <input type="hidden" value="{{ $product->photo }}" name="image">
                                            <input type="hidden" value="{{ $product->weight }}" name="weight">
                                            <a class="add-to-cart" href="">
                                                <button class="text-white" type="submit">Add To Cart</button>
                                            </a>
                                        </form>
                                        <?php } ?>
                                    </div>
                                    <div class="product-content">
                                        <ul class="star">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                        <h3 class="title">
                                            <a href="{{ route('productdetail', $product->slugname) }}">
                                                {{ $product->productname }}
                                            </a>
                                        </h3>
                                        <span class="price">
                                            ₹ {{ $product->rate }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        
         <!-- Modal1 -->
        <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
            <div class="overlay-modal1 js-hide-modal1"></div>

            <div class="container">
                <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                    <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                        <img src="{{ asset('assets/frontimages/icons/icon-close.png') }}" alt="CLOSE">
                    </button>

                    <div id="dataplacehere">

                    </div>
                </div>
            </div>
        </div>


    @endsection

    @section('scripts')
        <script>
            function increaseCount(a, b) {
                var input = b.previousElementSibling;
                var value = parseInt(input.value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                {{--  alert(value);  --}}
                {{--  input.value = value;  --}}

                $('#quantity').val(value);

            }

            function decreaseCount(a, b) {
                var input = b.nextElementSibling;
                var value = parseInt(input.value, 10);
                // alert(value);
                if (value > 1) {
                    value = isNaN(value) ? 0 : value;
                    value--;
                    {{--  input.value = value;  --}}
                }
                $('#quantity').val(value);
            }
        </script>
        
        
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
