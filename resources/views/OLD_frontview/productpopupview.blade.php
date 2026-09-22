<?php //dd($Product->rate);
?>
<!--<link rel="stylesheet" type="text/css" href="{{ asset('/assets/frontvendor/slick/slick.css') }}">-->
<link rel="stylesheet" type="text/css" href="{{ asset('../../assets/frontvendor/select2/select2.min.css') }}">

<div class="row">
    <div class="col-md-6 col-lg-7 p-b-30">
        <div class="p-l-25 p-r-30 p-lr-0-lg">
            <div class="wrap-slick3 flex-sb flex-w">
                <div class="wrap-slick3-dots"></div>
                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                <div class="slick3 gallery-lb">

                    @foreach ($Productphotos as $productphotos)
                        <div class="item-slick3"
                            data-thumb="{{ asset('Product/Thumbnail/') . '/' . $productphotos->strphoto }}">
                            <div class="wrap-pic-w2 pos-relative">
                                <img src="{{ asset('Product/Thumbnail/') . '/' . $productphotos->strphoto }}"
                                    alt="IMG-PRODUCT">

                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                    href="{{ asset('Product/') . '/' . $productphotos->strphoto }}">
                                    <i class="fa fa-expand"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="productid" id="getproductid" value="{{ $Product->productId }}">

    <div class="col-md-6 col-lg-5 p-b-30">
        <div class="p-r-50 p-t-5 p-lr-0-lg">
            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                {{ $Product->productname }}
            </h4>

            <span class="mtext-106 cl2">
                ₹ <span id="setprice">{{ $Product->rate }}</span>
                {{--  ₹{{ $Product->rate }}  --}}
            </span>

            <div class="p-t-33">
                <div class="flex-w flex-r-m p-b-10">
                    <div class="size-203 flex-c-m respon6">
                        Size
                    </div>

                    <div class="size-204 respon6-next">
                        <div class="rs1-select2 bor8 bg0">
                            <select class="js-select2" name="weight" id="getproductweight" onchange="getcartweight();">
                                <option selected value="0">
                                    {{ $Product->weight }}
                                </option>
                                @foreach ($Attribute as $ProductWeights)
                                    <option value="{{ $ProductWeights->id }}">
                                        {{ $ProductWeights->product_attribute_weight }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                    </div>
                </div>

            </div>
            <!--<div>-->
            <!--    <p class="">-->
            <!--        Size : &nbsp;-->
            <!--        <select name="weight" id="getproductweight" onchange="getcartweight();">-->
            <!--            <option selected value="0">-->
            <!--                {{ $Product->weight }}-->
            <!--            </option>-->
            <!--            @foreach ($Attribute as $ProductWeights)
-->
            <!--                <option value="{{ $ProductWeights->id }}">-->
            <!--                    {{ $ProductWeights->product_attribute_weight }}-->
            <!--                </option>-->
            <!--
@endforeach-->
            <!--        </select>-->

            <!--    </p>-->
            <!--</div>-->


            <!--<p class="stext-102 cl3 p-t-23 disc">-->
            <!--    {!! $Product->description !!}-->
            <!--</p>-->

            <ul class="pro-detail-t">
                <li class="disc">
                    {!! $Product->description !!}
                </li>
            </ul>

            <div class="p-t-33">

                <div class="flex-w flex-r-m p-b-10">
                    <div class="size-204 flex-w flex-m respon6-next">

                        <?php if($Product->isStock == 1){ ?>
                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                <div onClick='decreaseCount(event, this)'
                                    class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                </div>

                                <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                    value="1">

                                <div onClick='increaseCount(event, this)'
                                    class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                </div>
                            </div>

                            <input type="hidden" value="1" name="quantity" id="quantity">
                            <input type="hidden" value="{{ $Product->categoryId }}" name="categoryId">
                            <input type="hidden" value="{{ $Product->productId }}" name="productid">
                            <input type="hidden" value="{{ $Product->productname }}" name="productname">
                            {{--  <input type="hidden" value="{{ $Product->rate }}" name="price">  --}}

                            <input type="hidden" id="cartweight" name="weight" value="{{ $Product->weight }}" />
                            <input type="hidden" id="cartPrice" name="price">

                            {{--  <input type="hidden" value="{{ $Product->weight }}" name="weight">  --}}
                            <input type="hidden" value="{{ $Product->photo }}" name="image">
                            <button
                                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                Add to cart
                            </button>
                        </form>
                        <?php } ?>


                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script src="{{ asset('assets/frontvendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/frontjs/slick-custom.js') }}"></script>
<script src="{{ asset('../../assets/frontvendor/select2/select2.min.js') }}"></script>
<script>
    $(".js-select2").each(function() {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>


<script>
    function increaseCount(a, b) {
        var input = b.previousElementSibling;
        var value = parseInt(input.value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        input.value = value;

        $('#quantity').val(input.value);

    }

    function decreaseCount(a, b) {
        var input = b.nextElementSibling;
        var value = parseInt(input.value, 10);
        // alert(value);
        if (value > 1) {
            value = isNaN(value) ? 0 : value;
            value--;
            input.value = value;
        }
        $('#quantity').val(input.value);
    }
</script>

{{--  @section('scripts')  --}}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#getproductweight').on('change', function() {
        weightvalidation();
    });


    function weightvalidation() {
        var Weight = $('#getproductweight').val();
        var productid = $('#getproductid').val();
        var productprice = $('#setprice').val();
        var url = "{{ route('productweight.weightBind') }}";

        if (Weight) {
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    Weight: Weight,
                    productid: productid
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (obj.product_attribute_price == null) {
                        $('#setprice').html(obj.rate);
                        $('#cartweight').val(obj.weight);
                    } else {
                        $('#setprice').html(obj.product_attribute_price);
                        $('#cartweight').val(obj.product_attribute_weight);

                    }
                    getcartweight();
                }
            });
        }
    }
    $('document').ready(function() {

        weightvalidation();
        getcartweight();
    })

    function getcartweight() {
        var CartWeight = $('#cartweight').val();

        var CartPrice = $('#setprice').html();
        $('#cartweight').val(CartWeight);
        $('#cartPrice').val(CartPrice);
    }
</script>
<script></script>
{{--  @endsection  --}}
