@extends('layouts.front')

@section('title', 'Product Detail')

@section('content')


    <!-- Your content container -->
    {{-- <div id="content-container">

        <div class="overlay" id="overlay">
            <div class="loader"></div>
        </div>

        @include('common.front.frontalert')
        @include('common.alert')

    </div> --}}

    <main class="pdx-page">
        <!-- =================================================
                                             PRODUCT MAIN
                                        ================================================== -->
        <section class="pdx-product-section">
            <div class="container">
                <div class="pdx-product-layout">
                    <!-- =========================================
                                                         LEFT PRODUCT GALLERY
                                                    ========================================== -->
                    <div class="pdx-gallery">
                        <!-- THUMBNAILS -->
                        <div class="pdx-thumbnails">
                            @foreach ($Photos as $photo)
                                <button type="button" class="pdx-thumb {{ $loop->first ? 'active' : '' }}"
                                    data-image="{{ asset('/Product/Thumbnail/' . $photo->strphoto) }}">
                                    <img src="{{ asset('/Product/Thumbnail/' . $photo->strphoto) }}"
                                        alt="{{ $ProductDetail->productname }}">
                                </button>
                            @endforeach
                        </div>
                        <!-- MAIN PRODUCT IMAGE -->
                        <div class="pdx-main-image">
                            <div class="pdx-image-top">
                                @if ($ProductDetail->isFeatures)
                                    <span class="pdx-product-badge">FEATURED</span>
                                @endif

                            </div>
                            <img src="{{ $Photos->first() ? asset('/Product/Thumbnail/' . $Photos->first()->strphoto) : asset('assets/images/no-image.jpg') }}"
                                alt="{{ $ProductDetail->productname }}" id="pdxMainImage">
                        </div>
                    </div>
                    <!-- =========================================
                                                         RIGHT PRODUCT INFORMATION
                                                    ========================================== -->
                    <div class="pdx-info">
                        <!-- CATEGORY -->
                        <span class="pdx-category">
                            {{ $parentCategory->categoryname ?? '' }} • {{ $subcategory->categoryname }}
                        </span>
                        <!-- TITLE -->
                        <h1>
                            {{ $ProductDetail->productname }}
                        </h1>
                        <!-- SHORT INTRO -->
                        <p class="pdx-intro">
                            {{ strip_tags($ProductDetail->description ?? '') }}
                        </p>
                        <!-- =====================================
                                                             RATING
                                                        ====================================== -->
                        <div class="pdx-rating-row">
                            {{--  <div class="pdx-rating">
                                <strong>--</strong>
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="#pdxReviews">
                                Product information
                            </a>  --}}
                            <span class="pdx-divider"></span>
                            <span class="pdx-stock">
                                <i class="fa fa-check-circle"></i>
                                {{ $Attribute->sum('product_attribute_qty') > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                        <!-- =====================================
                                                             PRICE
                                                        ====================================== -->
                        <div class="pdx-price-block">
                            <div class="pdx-price">
                                <strong
                                    id="pdxCurrentPrice">₹{{ number_format($Attribute->min('product_attribute_price') ?: $ProductDetail->rate ?? 0, 0) }}</strong>
                                @if ($ProductDetail->rate && $ProductDetail->rate > $Attribute->min('product_attribute_price'))
                                    <del>₹{{ number_format($ProductDetail->rate, 0) }}</del>
                                    <span>{{ round((($ProductDetail->rate - $Attribute->min('product_attribute_price')) / $ProductDetail->rate) * 100) }}%
                                        OFF</span>
                                @endif
                            </div>
                        </div>
                        <!-- =====================================
                                                             DESCRIPTION
                                                        ====================================== -->
                        <div class="pdx-description">
                            <p>
                                {!! $ProductDetail->description !!}
                            </p>
                        </div>
                        <!-- =====================================
                                                             SIZE
                                                        ====================================== -->
                        <div class="pdx-option-block">
                            <div class="pdx-option-head">
                                <div>
                                    <span>Select Size</span>
                                    <strong
                                        id="pdxSelectedSize">{{ $Attribute->first()->product_attribute_size ?? 'N/A' }}</strong>
                                </div>
                                <button type="button" class="pdx-size-guide">
                                    <i class="fa fa-arrows-h"></i>
                                    Size Guide
                                </button>
                            </div>
                            <div class="pdx-size-list">
                                @foreach ($Attribute as $attribute)
                                    <button type="button" class="{{ $loop->first ? 'active' : '' }}"
                                        data-attribute-id="{{ $attribute->id }}"
                                        data-size="{{ $attribute->product_attribute_size }}"
                                        data-price="{{ $attribute->product_attribute_price }}"
                                        data-quantity="{{ $attribute->product_attribute_qty }}">
                                        {{ $attribute->product_attribute_size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <!-- =====================================
                                                             QUANTITY
                                                        ====================================== -->
                        <div class="pdx-quantity-row">
                            <span>
                                Quantity
                            </span>
                            <div class="pdx-quantity">
                                <button type="button" id="pdxQtyMinus">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="text" value="1" id="pdxQty" readonly>
                                <button type="button" id="pdxQtyPlus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- =====================================
                                                             ACTION BUTTONS
                                                        ====================================== -->
                        <div class="pdx-actions">
                            <form action="{{ route('cart.store') }}" method="POST" id="pdxCartForm">
                                @csrf
                                <input type="hidden" name="attributeid" id="pdxAttributeId">
                                <input type="hidden" name="product_attribute_size" id="pdxCartSize">
                                <input type="hidden" name="productid" value="{{ $ProductDetail->productId }}">
                                <input type="hidden" name="categoryId" value="{{ $ProductDetail->categoryId }}">
                                <input type="hidden" name="subcategoryid" value="{{ $ProductDetail->subcategoryid }}">
                                <input type="hidden" name="productslug" value="{{ $ProductDetail->slugname }}">
                                <input type="hidden" name="categoryslug" value="{{ $subcategory->slugname ?? '' }}">
                                <input type="hidden" name="categoryname" value="{{ $subcategory->categoryname ?? '' }}">
                                <input type="hidden" name="productname" value="{{ $ProductDetail->productname }}">
                                <input type="hidden" name="price" id="pdxCartPrice">
                                <input type="hidden" name="image" value="{{ $Photos->first()->strphoto ?? '' }}">
                                <input type="hidden" name="buttonValue" value="addtocart">
                                <input type="hidden" name="quant[1]" id="pdxCartQuantity" value="1">
                                <button type="submit" class="pdx-add-cart" id="pdxAddCart">
                                    <span>
                                        <i class="fa fa-shopping-bag"></i>
                                    </span>
                                    <strong id="pdxCartText">
                                        Add To Cart
                                    </strong>
                                    <i class="fa fa-long-arrow-right"></i>
                                </button>
                            </form>
                            <!-- =====================================
                                                             WISHLIST / SHARE
                                                        ====================================== -->
                            <div class="pdx-secondary-actions">
                                {{--  <button type="button" id="pdxWishlist" class="pdx-wishlist">
                                    <i class="fa fa-heart-o"></i>
                                    Add to Wishlist
                                </button>  --}}
                                <button type="button">
                                    <i class="fa fa-share-alt"></i>
                                    Share
                                </button>
                            </div>
                        </div>
                        <!-- =====================================
                                                             BENEFITS
                                                        ====================================== -->
                        <div class="pdx-benefits">
                            <div class="pdx-benefit">
                                <span class="pdx-benefit-icon pdx-blue">
                                    <i class="fa fa-truck"></i>
                                </span>
                                <div>
                                    <strong>
                                        Free Delivery
                                    </strong>
                                    <small>
                                        Above ₹999
                                    </small>
                                </div>
                            </div>
                            <div class="pdx-benefit">
                                <span class="pdx-benefit-icon pdx-green">
                                    <i class="fa fa-refresh"></i>
                                </span>
                                <div>
                                    <strong>
                                        Easy Returns
                                    </strong>
                                    <small>
                                        Within 7 days
                                    </small>
                                </div>
                            </div>
                            <div class="pdx-benefit">
                                <span class="pdx-benefit-icon pdx-orange">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <div>
                                    <strong>
                                        Secure Payment
                                    </strong>
                                    <small>
                                        Safe checkout
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                                             PRODUCT INFORMATION
                                        ================================================== -->
        <section class="pdx-detail-section">
            <div class="container">
                <div class="pdx-detail-layout">
                    <!-- LEFT -->
                    <div class="pdx-detail-heading">
                        <span>
                            MORE ABOUT THIS LOOK
                        </span>
                        <h2>
                            Little details,
                            <em>big comfort.</em>
                        </h2>
                        <p>
                            Everything you need to know about
                            this little wardrobe favourite.
                        </p>
                    </div>
                    <!-- RIGHT -->
                    <div class="pdx-accordion-list">
                        <!-- PRODUCT DETAILS -->
                        <div class="pdx-accordion active">
                            <button type="button" class="pdx-accordion-head">
                                <span>
                                    <i class="fa fa-info-circle"></i>
                                    Product Details
                                </span>
                                <i class="fa fa-minus"></i>
                            </button>
                            <div class="pdx-accordion-body">
                                <ul>
                                    @if ($ProductDetail->fabric)
                                        <li>Fabric: {{ $ProductDetail->fabric }}</li>
                                    @endif
                                    @if ($ProductDetail->care)
                                        <li>Care: {{ $ProductDetail->care }}</li>
                                    @endif
                                    @if ($ProductDetail->weight)
                                        <li>Weight: {{ $ProductDetail->weight }}</li>
                                    @endif
                                    @if (!$ProductDetail->fabric && !$ProductDetail->care && !$ProductDetail->weight)
                                        <li>No additional product details available.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- MATERIAL -->
                        <div class="pdx-accordion">
                            <button type="button" class="pdx-accordion-head">
                                <span>
                                    <i class="fa fa-leaf"></i>
                                    Material & Care
                                </span>
                                <i class="fa fa-plus"></i>
                            </button>
                            <div class="pdx-accordion-body">
                                <p>
                                    {{ $ProductDetail->care ?: 'Care information is not available.' }}
                                </p>
                            </div>
                        </div>
                        <!-- SHIPPING -->
                        <div class="pdx-accordion">
                            <button type="button" class="pdx-accordion-head">
                                <span>
                                    <i class="fa fa-truck"></i>
                                    Shipping & Returns
                                </span>
                                <i class="fa fa-plus"></i>
                            </button>
                            <div class="pdx-accordion-body">
                                <p>
                                    {{ $ProductDetail->disclaimer ?: 'Shipping and return information is not available.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                                             RELATED PRODUCTS
                                        ================================================== -->
        <section class="pdx-related">
            <div class="container">
                <div class="pdx-related-head">
                    <div>
                        <span>
                            MORE LITTLE FAVOURITES
                        </span>
                        <h2>
                            You May
                            <em>Also Like</em>
                        </h2>
                    </div>
                    <a href="product.html?gender=girls">
                        View All Girls
                        <span>
                            <i class="fa fa-long-arrow-right"></i>
                        </span>
                    </a>
                </div>
                <div class="pdx-related-grid">
                    <article class="pdx-related-card">
                        <div class="pdx-related-image">
                            <a href="#">
                                <img src="assets/images/girls-party.jpg" alt="Shimmer Party Dress">
                            </a>
                            <span>
                                Party Pick
                            </span>
                        </div>
                        <div class="pdx-related-content">
                            <small>
                                Girls • Party Wear
                            </small>
                            <a href="#">
                                Shimmer Party Dress
                            </a>
                            <div>
                                <strong>₹1,799</strong>
                                <del>₹2,299</del>
                                <span>22% OFF</span>
                            </div>
                        </div>
                    </article>
                    <article class="pdx-related-card">
                        <div class="pdx-related-image">
                            <a href="#">
                                <img src="assets/images/girls-skirts.jpg" alt="Pretty Pleated Skirt">
                            </a>
                            <span>
                                Popular
                            </span>
                        </div>
                        <div class="pdx-related-content">
                            <small>
                                Girls • Skirts
                            </small>
                            <a href="#">
                                Pretty Pleated Skirt
                            </a>
                            <div>
                                <strong>₹899</strong>
                                <del>₹1,199</del>
                                <span>25% OFF</span>
                            </div>
                        </div>
                    </article>
                    <article class="pdx-related-card">
                        <div class="pdx-related-image">
                            <a href="#">
                                <img src="assets/images/girls-dresses.jpg" alt="Rainbow Casual Dress">
                            </a>
                            <span>
                                New
                            </span>
                        </div>
                        <div class="pdx-related-content">
                            <small>
                                Girls • Dresses
                            </small>
                            <a href="#">
                                Rainbow Casual Dress
                            </a>
                            <div>
                                <strong>₹1,299</strong>
                                <del>₹1,699</del>
                                <span>24% OFF</span>
                            </div>
                        </div>
                    </article>
                    <article class="pdx-related-card">
                        <div class="pdx-related-image">
                            <a href="#">
                                <img src="assets/images/girls-party.jpg" alt="Festive Twirl Dress">
                            </a>
                            <span>
                                Festive
                            </span>
                        </div>
                        <div class="pdx-related-content">
                            <small>
                                Girls • Celebration
                            </small>
                            <a href="#">
                                Festive Twirl Dress
                            </a>
                            <div>
                                <strong>₹1,599</strong>
                                <del>₹2,099</del>
                                <span>24% OFF</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>
@endsection



@section('scripts')
    <script>
        (() => {
            const thumbnails = document.querySelectorAll('.pdx-thumb');
            const mainImage = document.getElementById('pdxMainImage');
            const sizeButtons = document.querySelectorAll('.pdx-size-list button');
            const selectedSize = document.getElementById('pdxSelectedSize');
            const currentPrice = document.getElementById('pdxCurrentPrice');
            const cartForm = document.getElementById('pdxCartForm');
            const cartPrice = document.getElementById('pdxCartPrice');
            const cartSize = document.getElementById('pdxCartSize');
            const attributeId = document.getElementById('pdxAttributeId');
            const cartQuantity = document.getElementById('pdxCartQuantity');
            const quantityInput = document.getElementById('pdxQty');

            thumbnails.forEach((thumbnail) => {
                thumbnail.addEventListener('click', () => {
                    thumbnails.forEach((item) => item.classList.remove('active'));
                    thumbnail.classList.add('active');
                    mainImage.src = thumbnail.dataset.image;
                });
            });

            const updateSelectedAttribute = (button) => {
                sizeButtons.forEach((item) => item.classList.remove('active'));
                button.classList.add('active');
                selectedSize.textContent = button.dataset.size;
                currentPrice.textContent = `₹${Number(button.dataset.price).toLocaleString('en-IN')}`;
                cartPrice.value = button.dataset.price;
                cartSize.value = button.dataset.size;
                attributeId.value = button.dataset.attributeId;
            };

            sizeButtons.forEach((button) => {
                button.addEventListener('click', () => updateSelectedAttribute(button));
            });

            const initialSize = document.querySelector('.pdx-size-list button.active');
            if (initialSize) updateSelectedAttribute(initialSize);

            document.getElementById('pdxQtyMinus')?.addEventListener('click', () => {
                quantityInput.value = Math.max(1, Number(quantityInput.value) - 1);
                cartQuantity.value = quantityInput.value;
            });
            document.getElementById('pdxQtyPlus')?.addEventListener('click', () => {
                quantityInput.value = Number(quantityInput.value) + 1;
                cartQuantity.value = quantityInput.value;
            });

            cartForm?.addEventListener('submit', (event) => {
                if (!attributeId.value) {
                    event.preventDefault();
                    alert('Please select a size.');
                }
            });
        })();
    </script>
@endsection
