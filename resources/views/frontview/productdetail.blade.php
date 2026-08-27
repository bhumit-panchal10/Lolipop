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
                            <button type="button" class="pdx-thumb active" data-image="assets/images/girls-dresses.jpg">
                                <img src="assets/images/girls-dresses.jpg" alt="Floral Summer Dress">
                            </button>
                            <button type="button" class="pdx-thumb" data-image="assets/images/girls-party.jpg">
                                <img src="assets/images/girls-party.jpg" alt="Floral Summer Dress alternate">
                            </button>
                            <button type="button" class="pdx-thumb" data-image="assets/images/girls-skirts.jpg">
                                <img src="assets/images/girls-skirts.jpg" alt="Floral Summer Dress detail">
                            </button>
                            <button type="button" class="pdx-thumb" data-image="assets/images/girls-dresses.jpg">
                                <img src="assets/images/girls-dresses.jpg" alt="Floral Summer Dress back">
                            </button>
                        </div>
                        <!-- MAIN PRODUCT IMAGE -->
                        <div class="pdx-main-image">
                            <div class="pdx-image-top">
                                <span class="pdx-product-badge">
                                    NEW STYLE
                                </span>
                                <button type="button" class="pdx-image-wishlist" id="pdxImageWishlist">
                                    <i class="fa fa-heart-o"></i>
                                </button>
                            </div>
                            <img src="assets/images/girls-dresses.jpg" alt="Floral Summer Dress" id="pdxMainImage">
                        </div>
                    </div>
                    <!-- =========================================
                         RIGHT PRODUCT INFORMATION
                    ========================================== -->
                    <div class="pdx-info">
                        <!-- CATEGORY -->
                        <span class="pdx-category">
                            GIRLS • DRESSES
                        </span>
                        <!-- TITLE -->
                        <h1>
                            Floral Summer Dress
                        </h1>
                        <!-- SHORT INTRO -->
                        <p class="pdx-intro">
                            Soft, playful and comfortable everyday style
                            designed for happy little adventures.
                        </p>
                        <!-- =====================================
                             RATING
                        ====================================== -->
                        <div class="pdx-rating-row">
                            <div class="pdx-rating">
                                <strong>4.8</strong>
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="#pdxReviews">
                                126 Reviews
                            </a>
                            <span class="pdx-divider"></span>
                            <span class="pdx-stock">
                                <i class="fa fa-check-circle"></i>
                                In Stock
                            </span>
                        </div>
                        <!-- =====================================
                             PRICE
                        ====================================== -->
                        <div class="pdx-price-block">
                            <div class="pdx-price">
                                <strong>
                                    ₹1,099
                                </strong>
                                <del>
                                    ₹1,499
                                </del>
                                <span>
                                    27% OFF
                                </span>
                            </div>
                        </div>
                        <!-- =====================================
                             DESCRIPTION
                        ====================================== -->
                        <div class="pdx-description">
                            <p>
                                A cheerful floral dress made with a soft,
                                breathable fabric and an easy everyday fit.
                                Perfect for play days, family outings and
                                little celebrations.
                            </p>
                        </div>
                        <!-- =====================================
                             COLOUR
                        ====================================== -->
                        <div class="pdx-option-block">
                            <div class="pdx-option-head">
                                <div>
                                    <span>Colour</span>
                                    <strong id="pdxSelectedColour">
                                        Pink
                                    </strong>
                                </div>
                            </div>
                            <div class="pdx-colour-list">
                                <button type="button" class="pdx-colour active" data-colour="Pink"
                                    style="--pdx-colour:#e88bad" aria-label="Pink"></button>
                                <button type="button" class="pdx-colour" data-colour="Purple" style="--pdx-colour:#b49bd1"
                                    aria-label="Purple"></button>
                                <button type="button" class="pdx-colour" data-colour="Yellow" style="--pdx-colour:#f0cb65"
                                    aria-label="Yellow"></button>
                                <button type="button" class="pdx-colour" data-colour="Sky Blue"
                                    style="--pdx-colour:#84c8e8" aria-label="Sky Blue"></button>
                            </div>
                        </div>
                        <!-- =====================================
                             SIZE
                        ====================================== -->
                        <div class="pdx-option-block">
                            <div class="pdx-option-head">
                                <div>
                                    <span>Select Size</span>
                                    <strong id="pdxSelectedSize">
                                        M
                                    </strong>
                                </div>
                                <button type="button" class="pdx-size-guide">
                                    <i class="fa fa-arrows-h"></i>
                                    Size Guide
                                </button>
                            </div>
                            <div class="pdx-size-list">
                                <button type="button" data-size="XS">
                                    XS
                                </button>
                                <button type="button" data-size="S">
                                    S
                                </button>
                                <button type="button" class="active" data-size="M">
                                    M
                                </button>
                                <button type="button" data-size="L">
                                    L
                                </button>
                                <button type="button" data-size="XL">
                                    XL
                                </button>
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
                            <a href="cart.html" class="pdx-add-cart" id="pdxAddCart">
                                <span>
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <strong id="pdxCartText">
                                    Add To Cart
                                </strong>
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                            <!-- =====================================
                             WISHLIST / SHARE
                        ====================================== -->
                            <div class="pdx-secondary-actions">
                                <button type="button" id="pdxWishlist" class="pdx-wishlist">
                                    <i class="fa fa-heart-o"></i>
                                    Add to Wishlist
                                </button>
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
                                    <li>Soft cotton-rich fabric</li>
                                    <li>Comfortable everyday fit</li>
                                    <li>Round neckline</li>
                                    <li>Lightweight and breathable</li>
                                    <li>Perfect for outings and celebrations</li>
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
                                    Cotton-rich fabric. Machine wash separately
                                    in cold water. Use mild detergent. Dry in shade
                                    and iron at a low temperature.
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
                                    Standard delivery time depends on location.
                                    Eligible products can be exchanged or returned
                                    within 7 days as per store policy.
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
@endsection
