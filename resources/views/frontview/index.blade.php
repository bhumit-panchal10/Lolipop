@extends('layouts.front')
@section('title', 'Home')
@section('content')
    <section class="hero-slider-section">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                <!-- GIRLS SLIDE -->
                <div class="swiper-slide hero-slide hero-slide-girls"
                    style="--hero-bg:url('Front/assets/images/slider-2.png');">
                    <div class="hero-slide-overlay"></div>
                    <div class="container hero-slide-inner">
                        <div class="hero-slide-content">
                            <span class="hero-slide-label">
                                NEW SEASON • GIRLS
                            </span>
                            <h1>
                                Bright styles for
                                <strong>happy little days.</strong>
                            </h1>
                            <p>
                                Playful dresses, easy sets and everyday favourites made for
                                school, celebrations and everything in between.
                            </p>
                            <div class="hero-slide-actions">
                                <a href="#" class="hero-primary-btn">
                                    <span class="hero-btn-text">
                                        Shop Girls
                                    </span>
                                    <span class="hero-btn-icon">
                                        <i class="fa fa-long-arrow-right"></i>
                                    </span>
                                </a>
                                <a href="#" class="hero-secondary-btn">
                                    <span>View Collection</span>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BOYS SLIDE -->
                <div class="swiper-slide hero-slide hero-slide-boys" style="--hero-bg:url('assets/images/slider-1.png');">
                    <div class="hero-slide-overlay"></div>
                    <div class="container hero-slide-inner">
                        <div class="hero-slide-content">
                            <span class="hero-slide-label">
                                EVERYDAY COOL • BOYS
                            </span>
                            <h1>
                                Easy fits made for
                                <strong>non-stop adventures.</strong>
                            </h1>
                            <p>
                                Comfortable tees, smart shirts and relaxed bottoms designed
                                to keep up with every busy little explorer.
                            </p>
                            <div class="hero-slide-actions">
                                <a href="#" class="hero-primary-btn">
                                    <span class="hero-btn-text">
                                        Shop Boys
                                    </span>
                                    <span class="hero-btn-icon">
                                        <i class="fa fa-long-arrow-right"></i>
                                    </span>
                                </a>
                                <a href="#" class="hero-secondary-btn">
                                    <span>View Collection</span>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BABY SLIDE -->
                <div class="swiper-slide hero-slide hero-slide-baby" style="--hero-bg:url('assets/images/slider-3.png');">
                    <div class="hero-slide-overlay"></div>
                    <div class="container hero-slide-inner">
                        <div class="hero-slide-content">
                            <span class="hero-slide-label">
                                SOFT ESSENTIALS • BABY
                            </span>
                            <h1>
                                Gentle comfort for
                                <strong>tiny everyday moments.</strong>
                            </h1>
                            <p>
                                Soft baby sets, cosy essentials and sweet little styles
                                created for cuddles, naps and first adventures.
                            </p>
                            <div class="hero-slide-actions">
                                <a href="#" class="hero-primary-btn">
                                    <span class="hero-btn-text">
                                        Shop Baby
                                    </span>
                                    <span class="hero-btn-icon">
                                        <i class="fa fa-long-arrow-right"></i>
                                    </span>
                                </a>
                                <a href="#" class="hero-secondary-btn">
                                    <span>View Collection</span>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SWIPER CONTROLS -->
            <div class="container hero-slider-controls">
                <!-- LEFT PAGINATION -->
                <div class="hero-pagination-wrap">
                    <span class="hero-pagination-label">
                        Explore
                    </span>
                    <div class="hero-swiper-pagination swiper-pagination"></div>
                </div>
                <!-- RIGHT NAVIGATION -->
                <div class="hero-slider-arrows">
                    <button class="hero-slider-arrow hero-swiper-prev" type="button" aria-label="Previous slide">
                        <i class="fa fa-angle-left"></i>
                    </button>
                    <button class="hero-slider-arrow hero-swiper-next" type="button" aria-label="Next slide">
                        <i class="fa fa-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-category-v2">
        <div class="container">
            <!-- HEADING -->
            <div class="category-v2-heading">
                <span class="category-v2-kicker">
                    DISCOVER LOLIPOP
                </span>
                <h2>Shop by Category</h2>
                <p>
                    Pick a category and discover styles made for every
                    little personality.
                </p>
            </div>
            <!-- =====================================================
                                 CATEGORY TABS
                            ====================================================== -->
            <div class="category-tabs" role="tablist">
                <button class="category-tab active" type="button" data-category="baby">
                    <span class="category-tab-icon baby-icon">
                        <i class="fa fa-child"></i>
                    </span>
                    <span>Baby</span>
                </button>
                <button class="category-tab" type="button" data-category="boys">
                    <span class="category-tab-icon boys-icon">
                        <i class="fa fa-male"></i>
                    </span>
                    <span>Boys</span>
                </button>
                <button class="category-tab" type="button" data-category="girls">
                    <span class="category-tab-icon girls-icon">
                        <i class="fa fa-female"></i>
                    </span>
                    <span>Girls</span>
                </button>
            </div>
            <!-- =====================================================
                                 BABY
                            ====================================================== -->
            <div class="category-panel active" data-panel="baby">
                <div class="category-slider-heading">
                    <div>
                        <span>BABY COLLECTION</span>
                        <h3>
                            Little essentials for tiny adventures
                        </h3>
                    </div>
                    <div class="category-slider-navigation">
                        <button class="category-slider-arrow category-prev" type="button" aria-label="Previous">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="category-slider-arrow category-next" type="button" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <div class="swiper subcategory-swiper">
                    <div class="swiper-wrapper">
                        <!-- 01 -->
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/baby-rompers.jpg" alt="Baby Rompers">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Soft Essentials</small>
                                            <h4>Rompers</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- 02 -->
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/baby-sets.jpg" alt="Baby Sets">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Everyday Comfort</small>
                                            <h4>Baby Sets</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- 03 -->
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/baby-sleepsuits.jpg" alt="Baby Sleepsuits">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Cosy Nights</small>
                                            <h4>Sleepsuits</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- 04 -->
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/baby-dungarees.jpg" alt="Baby Dungarees">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Cute Looks</small>
                                            <h4>Dungarees</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- 05 -->
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/baby-tshirts.jpg" alt="Baby T-Shirts">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Daily Wear</small>
                                            <h4>T-Shirts</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- 06 -->
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/baby-gift-sets.jpg" alt="Baby Gift Sets">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Made For Gifting</small>
                                            <h4>Gift Sets</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- =====================================================
                                 BOYS
                            ====================================================== -->
            <div class="category-panel" data-panel="boys">
                <div class="category-slider-heading">
                    <div>
                        <span>BOYS COLLECTION</span>
                        <h3>
                            Made to move, play and explore
                        </h3>
                    </div>
                    <div class="category-slider-navigation">
                        <button class="category-slider-arrow category-prev" type="button">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="category-slider-arrow category-next" type="button">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <div class="swiper subcategory-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/boys-tshirts.jpg" alt="Boys T-Shirts">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Everyday Cool</small>
                                            <h4>T-Shirts</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/boys-shirts.jpg" alt="Boys Shirts">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Smart Casual</small>
                                            <h4>Shirts</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/boys-capri.jpg" alt="Boys Capri">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Playtime Ready</small>
                                            <h4>Capri</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/boys-nightwear.jpg" alt="Boys Nightwear">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Cosy Nights</small>
                                            <h4>Nightwear</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/boys-jeans.jpg" alt="Boys Jeans">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Everyday Style</small>
                                            <h4>Jeans</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/boys-coord.jpg" alt="Boys Co-ord Sets">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Easy Matching</small>
                                            <h4>Co-ord Sets</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- =====================================================
                                 GIRLS
                            ====================================================== -->
            <div class="category-panel" data-panel="girls">
                <div class="category-slider-heading">
                    <div>
                        <span>GIRLS COLLECTION</span>
                        <h3>
                            Pretty styles for every happy moment
                        </h3>
                    </div>
                    <div class="category-slider-navigation">
                        <button class="category-slider-arrow category-prev">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="category-slider-arrow category-next">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
                <div class="swiper subcategory-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/girls-dresses.jpg" alt="Girls Dresses">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Twirl Ready</small>
                                            <h4>Dresses</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/girls-tops.jpg" alt="Girls Tops">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Everyday Pretty</small>
                                            <h4>Tops</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/girls-skirts.jpg" alt="Girls Skirts">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Playful Looks</small>
                                            <h4>Skirts</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/girls-coord.jpg" alt="Girls Co-ord Sets">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Matching Edit</small>
                                            <h4>Co-ord Sets</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/girls-nightwear.jpg" alt="Girls Nightwear">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Dreamy Comfort</small>
                                            <h4>Nightwear</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="subcategory-card">
                                <div class="subcategory-image">
                                    <img src="assets/images/girls-party.jpg" alt="Girls Party Wear">
                                    <div class="subcategory-content">
                                        <div>
                                            <small>Celebrate</small>
                                            <h4>Party Wear</h4>
                                        </div>
                                        <span class="subcategory-card-arrow">
                                            <i class="fa fa-long-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="season-sale-banner">
        <span class="sale-bg-shape sale-bg-shape-one"></span>
        <span class="sale-bg-shape sale-bg-shape-two"></span>
        <div class="container season-sale-inner">
            <!-- LEFT CONTENT -->
            <div class="season-sale-content">
                <span class="season-script">
                    End of the
                </span>
                <h2>
                    <span>SEASON</span>
                    <strong>SALE</strong>
                </h2>
                <h3>
                    Big styles. Bigger savings.
                </h3>
                <p>
                    Refresh their wardrobe with playful styles,
                    everyday essentials and comfy footwear —
                    all at special prices.
                </p>
                <!-- CATEGORY LINKS -->
                <div class="season-sale-categories">
                    <a href="#">
                        <span class="season-cat-icon girls-cat">
                            <i class="fa fa-female"></i>
                        </span>
                        <small>Girls</small>
                    </a>
                    <a href="#">
                        <span class="season-cat-icon boys-cat">
                            <i class="fa fa-male"></i>
                        </span>
                        <small>Boys</small>
                    </a>
                    <a href="#">
                        <span class="season-cat-icon baby-cat">
                            <i class="fa fa-child"></i>
                        </span>
                        <small>Baby</small>
                    </a>
                    <a href="#">
                        <span class="season-cat-icon footwear-cat">
                            <i class="fa fa-shopping-bag"></i>
                        </span>
                        <small>Footwear</small>
                    </a>
                </div>
                <!-- BOTTOM ACTION -->
                <div class="season-sale-action">
                    <a href="#" class="season-sale-btn">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Shop The Sale</span>
                        <span class="sale-btn-arrow">
                            <i class="fa fa-long-arrow-right"></i>
                        </span>
                    </a>
                    <span class="season-limited">
                        <i class="fa fa-clock-o"></i>
                        Limited Time Only
                    </span>
                </div>
            </div>
            <!-- RIGHT VISUAL -->
            <div class="season-sale-art">
                <img src="{{ '/Front/assets/images/end-sale-right-art.jpg' }}" alt="End of Season Sale Kidswear">
            </div>
        </div>
    </section>
    <!-- =========================================================
                             LOLIPOP - FEATURED PRODUCT GRID
                        ========================================================== -->
    <section class="lpx-products-section">
        <div class="container">
            <!-- =================================================
                                     SECTION HEADER
                                ================================================== -->
            <div class="lpx-section-header">
                <div class="lpx-heading">
                    <span class="lpx-kicker">
                        FRESH LITTLE FINDS
                    </span>
                    <h2>
                        Styles They’ll
                        <span>Love To Wear.</span>
                    </h2>
                    <p>
                        Happy colours, everyday comfort and playful styles
                        picked for every little adventure.
                    </p>
                </div>
            </div>
            <!-- =================================================
                                     PRODUCT GRID
                                ================================================== -->
            <div class="lpx-products-grid">
                <!-- =================================================
                                         PRODUCT 01
                                    ================================================== -->
                <article class="lpx-card lpx-girls" data-category="girls">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/girls-party.jpg" alt="Shimmer Party Dress"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/girls-dresses.jpg" alt="Shimmer Party Dress Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            New
                        </span>
                        <!-- LOWER ACTIONS -->
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Girls • Party Wear
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Shimmer Party Dress
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹1,799
                                </strong>
                                <del>
                                    ₹2,299
                                </del>
                                <span class="lpx-discount">
                                    22% OFF
                                </span>
                            </div>
                            <div class="lpx-color-list">
                                <span style="background:#eb87aa;"></span>
                                <span style="background:#b791cf;"></span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                                         PRODUCT 02
                                    ================================================== -->
                <article class="lpx-card lpx-boys" data-category="boys">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/boys-shirts.jpg" alt="Cool Casual Shirt"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/boys-tshirts.jpg" alt="Cool Casual Shirt Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            Best Seller
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Boys • Shirts
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Cool Casual Shirt
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹999
                                </strong>
                                <del>
                                    ₹1,299
                                </del>
                                <span class="lpx-discount">
                                    23% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                                         PRODUCT 03
                                    ================================================== -->
                <article class="lpx-card lpx-baby" data-category="baby">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/baby-sleepsuits.jpg" alt="Soft Cotton Sleepsuit"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/baby-rompers.jpg" alt="Soft Cotton Sleepsuit Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            Soft Pick
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Baby • Sleepsuits
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Soft Cotton Sleepsuit
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹849
                                </strong>
                                <del>
                                    ₹1,099
                                </del>
                                <span class="lpx-discount">
                                    23% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                             PRODUCT 04 - BOYS CO-ORD SET
                        ================================================== -->
                <article class="lpx-card lpx-boys" data-category="boys">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/boys-coord-sets.jpg" alt="Boys Casual Co-ord Set"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/boys-tshirts.jpg" alt="Boys Casual Co-ord Set Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            Trending
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Boys • Co-ord Sets
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Cool Everyday Co-ord Set
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹1,399
                                </strong>
                                <del>
                                    ₹1,799
                                </del>
                                <span class="lpx-discount">
                                    22% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                                         PRODUCT 05
                                    ================================================== -->
                <article class="lpx-card lpx-girls" data-category="girls">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/girls-skirts.jpg" alt="Pretty Everyday Skirt"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/girls-dresses.jpg" alt="Pretty Everyday Skirt Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            Trending
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Girls • Skirts
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Pretty Everyday Skirt
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹899
                                </strong>
                                <del>
                                    ₹1,199
                                </del>
                                <span class="lpx-discount">
                                    25% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                                         PRODUCT 06
                                    ================================================== -->
                <article class="lpx-card lpx-baby" data-category="baby">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/baby-rompers.jpg" alt="Everyday Baby Romper"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/baby-gift-sets.jpg" alt="Everyday Baby Romper Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            New
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Baby • Rompers
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Everyday Baby Romper
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹749
                                </strong>
                                <del>
                                    ₹999
                                </del>
                                <span class="lpx-discount">
                                    25% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                                         PRODUCT 07
                                    ================================================== -->
                <article class="lpx-card lpx-boys" data-category="boys">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/boys-jeans.jpg" alt="Classic Denim Jeans"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/boys-coord-sets.jpg" alt="Classic Denim Jeans Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            Popular
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Boys • Jeans
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Classic Denim Jeans
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹1,249
                                </strong>
                                <del>
                                    ₹1,599
                                </del>
                                <span class="lpx-discount">
                                    22% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- =================================================
                             PRODUCT 08 - GIRLS CASUAL DRESS
                        ================================================== -->
                <article class="lpx-card lpx-girls" data-category="girls">
                    <div class="lpx-image-box">
                        <a href="#" class="lpx-image-link">
                            <img src="assets/images/girls-dresses.jpg" alt="Girls Everyday Casual Dress"
                                class="lpx-img lpx-img-main">
                            <img src="assets/images/girls-party.jpg" alt="Girls Everyday Casual Dress Alternate View"
                                class="lpx-img lpx-img-hover">
                        </a>
                        <span class="lpx-badge">
                            New Style
                        </span>
                        <div class="lpx-card-actions">
                            <button class="lpx-wishlist" type="button" aria-label="Add to wishlist">
                                <i class="fa fa-heart-o"></i>
                            </button>
                            <button class="lpx-cart" type="button" aria-label="Add to cart">
                                <span class="lpx-cart-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <span class="lpx-cart-text">
                                    Add to Cart
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="lpx-card-content">
                        <div class="lpx-card-small-info">
                            <span class="lpx-category">
                                Girls • Casual Dresses
                            </span>
                        </div>
                        <a href="#" class="lpx-product-name">
                            Pretty Everyday Dress
                        </a>
                        <div class="lpx-price-row">
                            <div class="lpx-price">
                                <strong>
                                    ₹1,099
                                </strong>
                                <del>
                                    ₹1,499
                                </del>
                                <span class="lpx-discount">
                                    27% OFF
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <!-- =================================================
                                     BOTTOM BUTTON
                                ================================================== -->
            <div class="lpx-bottom-cta">
                <a href="#">
                    <span>
                        Explore All Products
                    </span>
                    <span class="lpx-bottom-arrow">
                        <i class="fa fa-long-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </section>
    <!-- ================================
                             CLIENTS + TESTIMONIAL SECTION
                        ================================= -->
    <section class="lc-social-proof">
        <!-- Decorative Background -->
        <div class="lc-proof-grid"></div>
        <span class="lc-proof-orb lc-orb-one"></span>
        <span class="lc-proof-orb lc-orb-two"></span>
        <!-- ===========================
                                 CLIENT LOGO SLIDER
                            ============================ -->
        <div class="lc-client-area">
            <div class="container">
                <div class="lc-client-heading">
                    <span></span>
                    <p>Trusted by growing brands</p>
                    <span></span>
                </div>
            </div>
            <div class="lc-logo-slider">
                <div class="lc-logo-track">
                    <!-- First Set -->
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-1.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-2.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-3.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-4.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-5.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-6.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-1.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-2.png" alt="Client">
                    </div>
                    <!-- Duplicate Set for Infinite Slider -->
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-1.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-2.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-3.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-4.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-5.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-6.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-1.png" alt="Client">
                    </div>
                    <div class="lc-logo-item">
                        <img src="assets/images/logo-2.png" alt="Client">
                    </div>
                </div>
            </div>
        </div>
        <!-- ===========================
                                 TESTIMONIAL SECTION
                            ============================ -->
        <div class="container">
            <div class="lc-testimonial-wrap">
                <!-- Left Content -->
                <div class="lc-testimonial-intro">
                    <div class="lc-mini-title">
                        <span></span>
                        CUSTOMER STORIES
                    </div>
                    <h2>
                        Loved by people
                        <span>who choose better.</span>
                    </h2>
                    <p>
                        Real experiences from customers who discovered products
                        they love and keep coming back for more.
                    </p>
                    <div class="lc-rating-box">
                        <div class="lc-rating-number">
                            4.9
                        </div>
                        <div>
                            <div class="lc-stars">
                                ★★★★★
                            </div>
                            <p>Based on customer reviews</p>
                        </div>
                    </div>
                    <!-- Slider Controls -->
                    <div class="lc-testimonial-controls">
                        <button class="lc-slider-btn lc-prev" type="button" aria-label="Previous testimonial">
                            <i class="fa fa-long-arrow-left"></i>
                        </button>
                        <div class="lc-slider-progress">
                            <span class="lc-current-slide">01</span>
                            <div class="lc-progress-line">
                                <span></span>
                            </div>
                            <span class="lc-total-slide">04</span>
                        </div>
                        <button class="lc-slider-btn lc-next" type="button" aria-label="Next testimonial">
                            <i class="fa fa-long-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- Right Slider -->
                <div class="lc-testimonial-slider-area">
                    <div class="lc-big-quote">
                        “
                    </div>
                    <div class="lc-testimonial-slider">
                        <div class="lc-testimonial-track">
                            <!-- Slide 1 -->
                            <article class="lc-testimonial-card">
                                <div class="lc-card-top">
                                    <span class="lc-verified">
                                        <i>✓</i>
                                        Verified Buyer
                                    </span>
                                    <span class="lc-card-stars">
                                        ★★★★★
                                    </span>
                                </div>
                                <p class="lc-review-text">
                                    I loved how simple it was to explore everything.
                                    The products arrived exactly as expected and
                                    everything from browsing to checkout felt smooth
                                    and thoughtfully designed.
                                </p>
                                <div class="lc-review-footer">
                                    <div class="lc-review-user">
                                        <div class="lc-user-avatar">
                                            <img src="images/user-1.jpg" alt="Customer">
                                        </div>
                                        <div>
                                            <strong>Olivia Martin</strong>
                                            <span>Happy Customer</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide 2 -->
                            <article class="lc-testimonial-card">
                                <div class="lc-card-top">
                                    <span class="lc-verified">
                                        <i>✓</i>
                                        Verified Buyer
                                    </span>
                                    <span class="lc-card-stars">
                                        ★★★★★
                                    </span>
                                </div>
                                <p class="lc-review-text">
                                    The quality is fantastic and the little details
                                    make a huge difference. My order was packed
                                    beautifully and I will definitely shop here again.
                                </p>
                                <div class="lc-review-footer">
                                    <div class="lc-review-user">
                                        <div class="lc-user-avatar">
                                            <img src="images/user-2.jpg" alt="Customer">
                                        </div>
                                        <div>
                                            <strong>Sophia Brown</strong>
                                            <span>Regular Customer</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide 3 -->
                            <article class="lc-testimonial-card">
                                <div class="lc-card-top">
                                    <span class="lc-verified">
                                        <i>✓</i>
                                        Verified Buyer
                                    </span>
                                    <span class="lc-card-stars">
                                        ★★★★★
                                    </span>
                                </div>
                                <p class="lc-review-text">
                                    Everything feels carefully selected instead of
                                    overwhelming. I found exactly what I wanted and
                                    the delivery experience was excellent too.
                                </p>
                                <div class="lc-review-footer">
                                    <div class="lc-review-user">
                                        <div class="lc-user-avatar">
                                            <img src="images/user-3.jpg" alt="Customer">
                                        </div>
                                        <div>
                                            <strong>Emma Wilson</strong>
                                            <span>Verified Customer</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide 4 -->
                            <article class="lc-testimonial-card">
                                <div class="lc-card-top">
                                    <span class="lc-verified">
                                        <i>✓</i>
                                        Verified Buyer
                                    </span>
                                    <span class="lc-card-stars">
                                        ★★★★★
                                    </span>
                                </div>
                                <p class="lc-review-text">
                                    From discovering the collection to receiving the
                                    package, the whole journey felt premium. I have
                                    already recommended it to friends.
                                </p>
                                <div class="lc-review-footer">
                                    <div class="lc-review-user">
                                        <div class="lc-user-avatar">
                                            <img src="images/user-4.jpg" alt="Customer">
                                        </div>
                                        <div>
                                            <strong>Mia Davis</strong>
                                            <span>Happy Customer</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
