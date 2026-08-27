@extends('layouts.front')
@section('title', 'Product')
@section('content')
    <main class="lshop-page" id="lshopPage">
        <!-- =================================================
             PRODUCT LISTING
        ================================================== -->
        <section class="lshop-section">
            <div class="container">
                <!-- =============================================
                     TOOLBAR
                ============================================== -->
                <div class="lshop-toolbar">
                    <div class="lshop-toolbar-left">
                        <button class="lshop-mobile-filter" id="lshopFilterOpen" type="button">
                            <i class="fa fa-sliders"></i>
                            Filters
                        </button>
                    </div>
                    <div class="lshop-toolbar-right">
                        <span>Sort By</span>
                        <div class="lshop-sort-box">
                            <select id="lshopSort">
                                <option value="featured">Featured</option>
                                <option value="low">Price: Low to High</option>
                                <option value="high">Price: High to Low</option>
                                <option value="discount">Highest Discount</option>
                            </select>
                            <i class="fa fa-angle-down"></i>
                        </div>
                    </div>
                </div>
                <!-- =============================================
                     MAIN LAYOUT
                ============================================== -->
                <div class="lshop-layout">
                    <!-- =========================================
         REDESIGNED LEFT FILTER
    ========================================== -->
                    <aside class="lshop-filter" id="lshopFilter">
                        <!-- MOBILE HEADER -->
                        <div class="lshop-filter-mobile-head">
                            <div>
                                <small>REFINE YOUR PICKS</small>
                                <strong>Filters</strong>
                            </div>
                            <button type="button" id="lshopFilterClose" aria-label="Close Filters">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <!-- =====================================
             FILTER TOP
        ====================================== -->
                        <div class="lshop-filter-head">
                            <div class="lshop-filter-head-icon">
                                <i class="fa fa-sliders"></i>
                            </div>
                            <div class="lshop-filter-head-copy">
                                <small>REFINE YOUR PICKS</small>
                                <h2>
                                    Shop Filters
                                </h2>
                            </div>
                            <button type="button" id="lshopClear">
                                Clear
                            </button>
                        </div>
                        <!-- =====================================
             CATEGORY
        ====================================== -->
                        <div class="lshop-filter-group lshop-filter-category">
                            <button type="button" class="lshop-filter-title">
                                <span class="lshop-filter-title-left">
                                    <span class="lshop-filter-title-icon">
                                        <i class="fa fa-th-large"></i>
                                    </span>
                                    <span>
                                        Category
                                    </span>
                                </span>
                                <span class="lshop-filter-toggle-icon">
                                    <i class="fa fa-minus"></i>
                                </span>
                            </button>
                            <div class="lshop-filter-body">
                                <div id="lshopCategoryFilters" class="lshop-category-list">
                                    <label class="lshop-check-row">
                                        <input type="checkbox" class="lshop-category-filter" value="dresses">
                                        <span class="lshop-check-box"></span>
                                        <span class="lshop-check-label">
                                            Dresses
                                        </span>
                                        <small>02</small>
                                    </label>
                                    <label class="lshop-check-row">
                                        <input type="checkbox" class="lshop-category-filter" value="tops">
                                        <span class="lshop-check-box"></span>
                                        <span class="lshop-check-label">
                                            Tops & T-Shirts
                                        </span>
                                        <small>01</small>
                                    </label>
                                    <label class="lshop-check-row">
                                        <input type="checkbox" class="lshop-category-filter" value="bottom-wear">
                                        <span class="lshop-check-box"></span>
                                        <span class="lshop-check-label">
                                            Bottom Wear
                                        </span>
                                        <small>01</small>
                                    </label>
                                    <label class="lshop-check-row">
                                        <input type="checkbox" class="lshop-category-filter" value="coord-sets">
                                        <span class="lshop-check-box"></span>
                                        <span class="lshop-check-label">
                                            Co-ord Sets
                                        </span>
                                        <small>01</small>
                                    </label>
                                    <label class="lshop-check-row">
                                        <input type="checkbox" class="lshop-category-filter" value="party-wear">
                                        <span class="lshop-check-box"></span>
                                        <span class="lshop-check-label">
                                            Party Wear
                                        </span>
                                        <small>01</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- =====================================
             PRICE
        ====================================== -->
                        <div class="lshop-filter-group lshop-filter-price">
                            <button type="button" class="lshop-filter-title">
                                <span class="lshop-filter-title-left">
                                    <span class="lshop-filter-title-icon">
                                        <i class="fa fa-inr"></i>
                                    </span>
                                    <span>
                                        Price
                                    </span>
                                </span>
                                <span class="lshop-filter-toggle-icon">
                                    <i class="fa fa-minus"></i>
                                </span>
                            </button>
                            <div class="lshop-filter-body">
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" value="0-500">
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        Under ₹500
                                    </span>
                                </label>
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" value="500-1000">
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        ₹500 – ₹1,000
                                    </span>
                                </label>
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" value="1000-1500">
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        ₹1,000 – ₹1,500
                                    </span>
                                </label>
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" value="1500-999999">
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        ₹1,500 & Above
                                    </span>
                                </label>
                            </div>
                        </div>
                        <!-- =====================================
             SIZE
        ====================================== -->
                        <div class="lshop-filter-group lshop-filter-size">
                            <button type="button" class="lshop-filter-title">
                                <span class="lshop-filter-title-left">
                                    <span class="lshop-filter-title-icon">
                                        <i class="fa fa-arrows-h"></i>
                                    </span>
                                    <span>
                                        Size
                                    </span>
                                </span>
                                <span class="lshop-filter-toggle-icon">
                                    <i class="fa fa-minus"></i>
                                </span>
                            </button>
                            <div class="lshop-filter-body">
                                <p class="lshop-size-note">
                                    Choose one or more sizes
                                </p>
                                <div class="lshop-size-filter">
                                    <button type="button" data-size="xs">
                                        XS
                                    </button>
                                    <button type="button" data-size="s">
                                        S
                                    </button>
                                    <button type="button" data-size="m">
                                        M
                                    </button>
                                    <button type="button" data-size="l">
                                        L
                                    </button>
                                    <button type="button" data-size="xl">
                                        XL
                                    </button>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- =========================================
                         RIGHT PRODUCTS
                    ========================================== -->
                    <div class="lshop-products-area">
                        <!-- ACTIVE FILTERS -->
                        <div class="lshop-active-filters" id="lshopActiveFilters"></div>
                        <!-- =====================================
                             PRODUCT GRID
                        ====================================== -->
                        <div class="lshop-product-grid" id="lshopProductGrid">
                            <!-- =================================
                                 GIRLS PRODUCT 01
                            ================================== -->
                            <article class="lshop-card" data-gender="girls" data-category="dresses" data-price="1099"
                                data-discount="27" data-size="xs s m">
                                <div class="lshop-card-image">
                                    <a href="product-detail.html">
                                        <img src="assets/images/girls-dresses.jpg" alt="Floral Summer Dress"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/girls-party.jpg" alt="Floral Summer Dress alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        New Style
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist" aria-label="Wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart" aria-label="Add to cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Girls • Dresses
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Floral Summer Dress
                                    </a>
                                    <div class="lshop-card-price">
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
                            </article>
                            <!-- =================================
                                 GIRLS PRODUCT 02
                            ================================== -->
                            <article class="lshop-card" data-gender="girls" data-category="party-wear" data-price="1799"
                                data-discount="22" data-size="s m l">
                                <div class="lshop-card-image">
                                    <a href="product-detail.html">
                                        <img src="assets/images/girls-party.jpg" alt="Shimmer Party Dress"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/girls-dresses.jpg" alt="Shimmer Party Dress alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Party Pick
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Girls • Party Wear
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Shimmer Party Dress
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>
                                            ₹1,799
                                        </strong>
                                        <del>
                                            ₹2,299
                                        </del>
                                        <span>
                                            22% OFF
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <!-- =================================
                                 GIRLS PRODUCT 03
                            ================================== -->
                            <article class="lshop-card" data-gender="girls" data-category="bottom-wear" data-price="899"
                                data-discount="25" data-size="s m l">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/girls-skirts.jpg" alt="Pretty Pleated Skirt"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/girls-dresses.jpg" alt="Pretty Pleated Skirt alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Popular
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Girls • Skirts
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Pretty Pleated Skirt
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>
                                            ₹899
                                        </strong>
                                        <del>
                                            ₹1,199
                                        </del>
                                        <span>
                                            25% OFF
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <!-- =================================
                                 GIRLS PRODUCT 04
                            ================================== -->
                            <article class="lshop-card" data-gender="girls" data-category="coord-sets" data-price="1399"
                                data-discount="22" data-size="m l xl">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/girls-dresses.jpg" alt="Pastel Co-ord Set"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/girls-skirts.jpg" alt="Pastel Co-ord Set alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Trending
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Girls • Co-ord Sets
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Pastel Everyday Co-ord Set
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>
                                            ₹1,399
                                        </strong>
                                        <del>
                                            ₹1,799
                                        </del>
                                        <span>
                                            22% OFF
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <!-- =================================
                                 GIRLS PRODUCT 05
                            ================================== -->
                            <article class="lshop-card" data-gender="girls" data-category="tops" data-price="749"
                                data-discount="25" data-size="xs s m">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/girls-party.jpg" alt="Cute Printed Cotton Top"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/girls-dresses.jpg" alt="Cute Printed Cotton Top alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Everyday Pick
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Girls • Tops
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Cute Printed Cotton Top
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>
                                            ₹749
                                        </strong>
                                        <del>
                                            ₹999
                                        </del>
                                        <span>
                                            25% OFF
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <!-- =================================
                                 GIRLS PRODUCT 06
                            ================================== -->
                            <article class="lshop-card" data-gender="girls" data-category="dresses" data-price="1299"
                                data-discount="24" data-size="s m l xl">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/girls-dresses.jpg" alt="Rainbow Casual Dress"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/girls-party.jpg" alt="Rainbow Casual Dress alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        New
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Girls • Dresses
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Rainbow Casual Dress
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>
                                            ₹1,299
                                        </strong>
                                        <del>
                                            ₹1,699
                                        </del>
                                        <span>
                                            24% OFF
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <!-- =================================
                                 BOYS PRODUCT 01
                            ================================== -->
                            <article class="lshop-card" data-gender="boys" data-category="shirts" data-price="999"
                                data-discount="23" data-size="s m l">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/boys-shirts.jpg" alt="Classic Checked Shirt"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/boys-tshirts.jpg" alt="Classic Checked Shirt alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Bestseller
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Boys • Shirts
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Classic Checked Shirt
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹999</strong>
                                        <del>₹1,299</del>
                                        <span>23% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- BOYS PRODUCT 02 -->
                            <article class="lshop-card" data-gender="boys" data-category="tshirts" data-price="699"
                                data-discount="22" data-size="xs s m">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/boys-tshirts.jpg" alt="Adventure Graphic T-Shirt"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/boys-shirts.jpg" alt="Adventure Graphic T-Shirt alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Everyday
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Boys • T-Shirts
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Adventure Graphic T-Shirt
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹699</strong>
                                        <del>₹899</del>
                                        <span>22% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- BOYS PRODUCT 03 -->
                            <article class="lshop-card" data-gender="boys" data-category="coord-sets" data-price="1399"
                                data-discount="22" data-size="m l xl">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/boys-coord-sets.jpg" alt="Weekend Casual Co-ord Set"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/boys-tshirts.jpg"
                                            alt="Weekend Casual Co-ord Set alternate" class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Trending
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Boys • Co-ord Sets
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Weekend Casual Co-ord Set
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹1,399</strong>
                                        <del>₹1,799</del>
                                        <span>22% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- BOYS PRODUCT 04 -->
                            <article class="lshop-card" data-gender="boys" data-category="bottom-wear" data-price="1249"
                                data-discount="22" data-size="s m l xl">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/boys-jeans.jpg" alt="Classic Denim Jeans"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/boys-coord-sets.jpg" alt="Classic Denim Jeans alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Popular
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Boys • Jeans
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Classic Denim Jeans
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹1,249</strong>
                                        <del>₹1,599</del>
                                        <span>22% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- =================================
                                 BABY PRODUCT 01
                            ================================== -->
                            <article class="lshop-card" data-gender="baby" data-category="rompers" data-price="749"
                                data-discount="25" data-size="xs s">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/baby-rompers.jpg" alt="Soft Cotton Baby Romper"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/baby-sleepsuits.jpg"
                                            alt="Soft Cotton Baby Romper alternate" class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        New
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Baby • Rompers
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Soft Cotton Baby Romper
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹749</strong>
                                        <del>₹999</del>
                                        <span>25% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- BABY PRODUCT 02 -->
                            <article class="lshop-card" data-gender="baby" data-category="sleepsuits" data-price="849"
                                data-discount="23" data-size="xs s">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/baby-sleepsuits.jpg" alt="Cosy Night Sleepsuit"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/baby-rompers.jpg" alt="Cosy Night Sleepsuit alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Soft Pick
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Baby • Sleepsuits
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Cosy Night Sleepsuit
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹849</strong>
                                        <del>₹1,099</del>
                                        <span>23% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- BABY PRODUCT 03 -->
                            <article class="lshop-card" data-gender="baby" data-category="gift-sets" data-price="1199"
                                data-discount="20" data-size="xs">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/baby-gift-sets.jpg" alt="Little Love Gift Set"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/baby-rompers.jpg" alt="Little Love Gift Set alternate"
                                            class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Gift Pick
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Baby • Gift Sets
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Little Love Gift Set
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹1,199</strong>
                                        <del>₹1,499</del>
                                        <span>20% OFF</span>
                                    </div>
                                </div>
                            </article>
                            <!-- BABY PRODUCT 04 -->
                            <article class="lshop-card" data-gender="baby" data-category="baby-sets" data-price="949"
                                data-discount="24" data-size="xs s">
                                <div class="lshop-card-image">
                                    <a href="#">
                                        <img src="assets/images/baby-gift-sets.jpg" alt="Everyday Baby Clothing Set"
                                            class="lshop-card-img-main">
                                        <img src="assets/images/baby-sleepsuits.jpg"
                                            alt="Everyday Baby Clothing Set alternate" class="lshop-card-img-hover">
                                    </a>
                                    <span class="lshop-card-badge">
                                        Comfy Pick
                                    </span>
                                    <div class="lshop-card-actions">
                                        <button type="button" class="lshop-wishlist">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button type="button" class="lshop-cart">
                                            <i class="fa fa-shopping-bag"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="lshop-card-content">
                                    <span class="lshop-card-category">
                                        Baby • Sets
                                    </span>
                                    <a href="product-detail.html" class="lshop-card-name">
                                        Everyday Baby Clothing Set
                                    </a>
                                    <div class="lshop-card-price">
                                        <strong>₹949</strong>
                                        <del>₹1,249</del>
                                        <span>24% OFF</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- EMPTY RESULT -->
                        <div class="lshop-empty" id="lshopEmpty">
                            <span>
                                <i class="fa fa-search"></i>
                            </span>
                            <h3>
                                No Products Found
                            </h3>
                            <p>
                                Try changing or clearing your filters.
                            </p>
                            <button type="button" id="lshopEmptyClear">
                                Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="lshop-overlay" id="lshopOverlay"></div>
    </main>

@endsection

@section('scripts')

@endsection
