@extends('layouts.front')
@section('title', 'Features')
@section('content')
    @include('common.frontalert')

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('/assets/frontimages/catagory/SHOP.jpg');">
        <h1 class="ltext-105 cl0 txt-center">
            Our Features
        </h1>
        <div class="bredcrum">
            <ul>
                <li><a class="text-white" href="{{ route('FrontIndex') }}">Home</a></li>
                <li><img src="{{ asset('assets/images/breadcrumb.png') }}" alt=""></li>
                <li>Our Features</li>
            </ul>
        </div>
    </section>
    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">


            <div class="flex-w justify-end p-b-52">


                <div class="flex-w flex-c-m m-tb-10 justify-center mt-5">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <form action="" method="post">
                        <div class="bor8 dis-flex p-l-15">
                            <button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>

                            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                                id="search" placeholder="Search">
                        </div>
                    </form>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">


                        <div class="filter-col4 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Tags
                            </div>

                            <div class="flex-w p-t-4 m-r--5">
                                @foreach ($Category as $category)
                                    <?php
                                    if($category->slugname == $id){ ?>
                                    <a href="#"
                                        class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 tags-active">
                                        {{ $category->categoryname }}
                                    </a>
                                    <?php }else{ ?>
                                    <a href="{{ route('IsFeatures', $category->slugname) }}"
                                        class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                        {{ $category->categoryname }}
                                    </a>
                                    <?php } ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div id="productdiv" class="row">
                <?php if($ProductCount == 0){ ?>
                <div class="col-md-12 col-sm-6">
                    <h2 class="text-center">No data Found!</h2>
                </div>
                <?php }else{ ?>
                @foreach ($Product as $product)
                    <div class="col-6 col-md-3 col-lg-3">
                        <div class="product-grid2">
                            <div class="product-image2">
                                <a href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">
                                    <img class="pic-1" src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}">

                                    <?php if($product->backphoto){ ?>
                                    <img class="pic-2" src="{{ asset('Product/Thumbnail/') . '/' . $product->backphoto }}">
                                    <?php }else{ ?>
                                    <img class="pic-2" src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}">
                                    <?php } ?>

                                </a>
                                <ul class="social">
                                    <li>
                                        <a href="#" class="js-show-modal1"
                                            onclick="getpopupdata(<?= $product->productId ?>)" data-tip="Quick View">
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
                                    {{--  <li>
                                        <a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                    </li>  --}}
                                </ul>
                                <?php if($product->isStock == 1){ ?>
                                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="1" name="quantity">
                                    <input type="hidden" value="{{ $product->categoryId }}" name="categoryId">
                                    <input type="hidden" value="{{ $product->productId }}" name="productid">
                                    <input type="hidden" value="{{ $product->productname }}" name="productname">
                                    <input type="hidden" value="{{ $product->rate }}" name="price">
                                    <input type="hidden" value="{{ $product->photo }}" name="image">
                                    <input type="hidden" value="{{ $product->weight }}" name="weight">
                                    <a class="add-to-cart" href="#">
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
                                    <a
                                        href="{{ route('productdetail', [$product->categoryslug, $product->slugname]) }}">{{ $product->productname }}</a>
                                </h3>
                                <span class="price">₹ {{ $product->rate }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center mt-3">
                    {{ $Product->appends(request()->except('page'))->links() }}
                </div>
                <?php } ?>
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

    <script>
        $('#search').on('keyup', function() {
            search();
        });

        function search() {
            var keyword = $('#search').val();
            if (keyword != "") {
                $.ajax({
                    url: '{{ route('searchfeaturesproduct') }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        keyword: keyword
                    },

                    success: function(data) {
                        table_post_row(data);
                        console.log(data);
                    },
                });
            } else {
                window.location.href = "";
            }

        };


        function table_post_row(res) {
            let htmlView = '';
            if (res.product.length <= 0) {
                htmlView += `
                <div class="col-md-12 col-sm-6">
                    <h2 class="text-center">No data Found.</h2>
                </div>`;
            }
            for (let i = 0; i < res.product.length; i++) {
                htmlView += `


            <div class="col-md-3 col-sm-6">
                <div class="product-grid2">
                    <div class="product-image2">
                        <a href="#"> `;

                // htmlView += `<img class="pic-1" src=/Product/Thumbnail/` + res.product[i].photo + `>
            //         <img class="pic-2" src=/Product/Thumbnail/` + res.product[i].backphoto + ` >


            htmlView += `<img class="pic-1" src=/Product/Thumbnail/` + res.product[i].photo + `>`;
            if (res.product[i].backphoto == "") {
                htmlView += `<img class="pic-2" src=/Product/Thumbnail/` + res.product[i].backphoto + ` >`;
            } else {
                htmlView += `<img class="pic-2" src=/Product/Thumbnail/` + res.product[i].photo + `>`;
            }
            htmlView += `</a>

                                </a>
                                <ul class="social">
                                    <li>
                                        <a href="#" class="js-show-modal1"
                                            onclick="getpopupdata(` + res.product[i].productId + `)" data-tip="Quick View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('wishlist') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value=` + res.product[i].productId + ` name="productid">
                                            <button class="text-white" type="submit">
                                                <a href="#" data-tip="Add to Wishlist">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                    </li>
                                </ul>
                                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="1" name="quantity">
                                    <input type="hidden" value=` + res.product[i].productId + ` name="productid">
                                    <input type="hidden" value=` + res.product[i].productname + ` name="productname">
                                    <input type="hidden" value=` + res.product[i].rate + ` name="price">
                                    <input type="hidden" value=` + res.product[i].photo + ` name="image">
                                    <input type="hidden" value=` + res.product[i].weight + ` name="weight">
                                    <a class="add-to-cart" href="#">
                                        <button class="text-white" type="submit">Add To Cart</button>
                                    </a>
                                </form>
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
                                    <a href="#">` + res.product[i].productname + `</a>
                                </h3>
                                <span class="price">₹` + res.product[i].rate + `</span>
                            </div>
                        </div>
                    </div>
                            `;
            }
            $('#productdiv').html(htmlView);
        }
    </script>

@endsection
