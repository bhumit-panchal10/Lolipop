@extends('layouts.front')
@section('title', 'Home')
@section('content')
    <style>
        .category-tab-icon {
            transition: all 0.3s ease;
        }

        /* Boys */
        .boys-wear-icon {
            --category-bg: #eaf7ff;
            --category-color: #18a9e8;
        }

        /* Girls */
        .girls-wear-icon {
            --category-bg: #fff0f8;
            --category-color: #e83e9d;
        }

        /* Discounted */
        .discounted-outfit-icon {
            --category-bg: #fff4e5;
            --category-color: #c98a32;
        }


        /* Normal state */
        .category-tab-icon {
            background: var(--category-bg);
            color: var(--category-color);
        }


        /* ACTIVE state */
        .category-tab.active .category-tab-icon {
            background: var(--category-color);
            color: #fff;
        }
    </style>
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
                            {{--  <div class="hero-slide-actions">
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
                            </div>  --}}
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
                            {{--  <div class="hero-slide-actions">
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
                            </div>  --}}
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
                            {{--  <div class="hero-slide-actions">
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
                            </div>  --}}
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


            <div class="category-tabs" role="tablist">

                @foreach ($categories as $key => $category)
                    <button class="category-tab {{ $key == 0 ? 'active' : '' }}" type="button"
                        data-category="{{ $category->categoryId }}">

                        <span class="category-tab-icon {{ $category->slugname }}-icon">

                            <i
                                class="fa
                    @if ($category->slugname == 'boys-wear') fa-male
                    @elseif($category->slugname == 'girls-wear')
                        fa-female
                    @elseif($category->slugname == 'discounted-outfit')
                        fa-tag @endif
                "></i>

                        </span>

                        <span>{{ $category->categoryname }}</span>

                    </button>
                @endforeach

            </div>
            <!-- =====================================================
                                                                                                                                                              subcategory show
                                                                                                                                                         ====================================================== -->

            <div class="category-panel active" id="dynamic-category-panel">

                <div class="category-slider-heading">

                    <div>

                        <span id="category-title">
                            {{ strtoupper($firstCategory->categoryname ?? '') }} COLLECTION
                        </span>

                        <h3 id="category-description">
                            {{ $firstCategory->meta_description ?? '' }}
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

                    <div class="swiper-wrapper" id="subcategory-wrapper">

                        @foreach ($subCategories as $subcategory)
                            <div class="swiper-slide">

                                <a href="{{ route('FrontProduct', ['slug' => $subcategory->slugname]) }}"
                                    class="subcategory-card">

                                    <div class="subcategory-image">

                                        <img src="{{ asset('Category/' . $subcategory->photo) }}"
                                            alt="{{ $subcategory->categoryname }}">

                                        <div class="subcategory-content">

                                            <div>

                                                <small>
                                                    {{ $subcategory->meta_description }}
                                                </small>

                                                <h4>
                                                    {{ $subcategory->categoryname }}
                                                </h4>

                                            </div>

                                            <span class="subcategory-card-arrow">
                                                <i class="fa fa-long-arrow-right"></i>
                                            </span>

                                        </div>

                                    </div>

                                </a>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>
            {{--  <div class="category-panel active" data-panel="baby">
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
                                    <img src="{{ asset('Front/assets/images/baby-rompers.jpg') }}" alt="Baby Rompers">
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
                                    <img src="{{ asset('Front/assets/images/baby-sets.jpg') }}" alt="Baby Sets">
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
                                    <img src="{{ asset('Front/assets/images/baby-sleepsuits.jpg') }}" alt="Baby Sleepsuits">
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
                                    <img src="{{ asset('Front/assets/images/baby-dungarees.jpg') }}" alt="Baby Dungarees">
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
                                    <img src="{{ asset('Front/assets/images/baby-tshirts.jpg') }}" alt="Baby T-Shirts">
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
                                    <img src="{{ asset('Front/assets/images/baby-gift-sets.jpg') }}" alt="Baby Gift Sets">
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
            </div>  --}}

        </div>
    </section>

    <section class="season-sale-banner">
        <span class="sale-bg-shape sale-bg-shape-one"></span>
        <span class="sale-bg-shape sale-bg-shape-two"></span>
        <div class="container season-sale-inner">
            <!-- =====================================================
                                 LEFT CONTENT
                            ====================================================== -->
            <div class="season-sale-content simple-brand-content">

                <!-- SMALL LABEL -->
                <span class="simple-brand-label">
                    ABOUT LOLIPOP
                </span>


                <!-- MAIN WELCOME -->
                <h2 class="simple-brand-heading">
                    Welcome to
                    <span>lollipop children wear.</span>
                </h2>


                <!-- CONTENT -->
                <p class="simple-brand-description">
                    A modern clothing brand dedicated to designing stylish,
                    comfortable and high quality apparel for boys and girls.
                    We serve age group between <strong>6 months to 15 years.</strong>
                    Our collection are inspired by today's fashion trends while
                    keeping comfort, durability and practicality at the core.
                </p>


                <p class="simple-brand-description simple-brand-description-last">
                    From everyday casual wear to special occasion outfits,
                    we create clothing that allows children to move freely,
                    feel confident and express their personality.
                </p>


                <!-- BOTTOM -->
                <div class="simple-brand-bottom">

                    <a href="#" class="simple-brand-btn">

                        <span>
                            Explore Collection
                        </span>

                        <i class="fa fa-long-arrow-right"></i>

                    </a>


                    <div class="simple-brand-age">

                        <i class="fa fa-child"></i>

                        <div>
                            <small>
                                AGE GROUP
                            </small>

                            <strong>
                                6 Months – 15 Years
                            </strong>
                        </div>

                    </div>

                </div>

            </div>
            <!-- RIGHT VISUAL -->
            <div class="season-sale-art">
                <img src="{{ asset('Front/assets/images/sale-offer.webp') }}" alt="End of Season Sale Kidswear">
            </div>
        </div>
    </section>

    <section class="lpx-products-section">
        <div class="container">

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

            <div class="lpx-products-grid">
                @foreach ($latestProducts as $product)
                    @php
                        $productPrice = $product->product_attribute_price ?? ($product->rate ?? 0);
                        $discount =
                            $product->rate > $productPrice && $product->rate > 0
                                ? round((($product->rate - $productPrice) / $product->rate) * 100)
                                : 0;
                        $productUrl =
                            $product->subcategoryslug && $product->slugname
                                ? route('productdetail.slugs', [
                                    'subcategory' => $product->subcategoryslug,
                                    'product' => $product->slugname,
                                ])
                                : '#';
                    @endphp
                    <article class="lpx-card" data-category="{{ $product->categoryslug }}">
                        <div class="lpx-image-box">
                            <a href="{{ $productUrl }}" class="lpx-image-link">
                                <img src="{{ $product->photo ? asset('/Product/Thumbnail/' . $product->photo) : asset('assets/images/no-image.jpg') }}"
                                    alt="{{ $product->productname }}" class="lpx-img lpx-img-main">
                                <img src="{{ $product->hoverphoto ? asset('/Product/Thumbnail/' . $product->hoverphoto) : ($product->photo ? asset('/Product/Thumbnail/' . $product->photo) : asset('assets/images/no-image.jpg')) }}"
                                    alt="{{ $product->productname }}" class="lpx-img lpx-img-hover">
                            </a>
                            @if ($discount > 0)
                                <span class="lpx-badge">{{ $discount }}% OFF</span>
                            @endif
                            <!-- LOWER ACTIONS -->
                            <div class="lpx-card-actions">

                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="attributeid"
                                        value="{{ $product->lowest_attribute_id }}">
                                    <input type="hidden" name="product_attribute_size"
                                        value="{{ $product->lowest_attribute_size }}">
                                    <input type="hidden" name="productid" value="{{ $product->productId }}">
                                    <input type="hidden" name="categoryId" value="{{ $product->categoryId }}">
                                    <input type="hidden" name="subcategoryid" value="{{ $product->subcategoryid }}">
                                    <input type="hidden" name="productslug" value="{{ $product->slugname }}">
                                    <input type="hidden" name="categoryslug"
                                        value="{{ $product->subcategoryslug ?? $product->categoryslug }}">
                                    <input type="hidden" name="categoryname"
                                        value="{{ $product->subcategoryname ?? $product->categoryname }}">
                                    <input type="hidden" name="productname" value="{{ $product->productname }}">
                                    <input type="hidden" name="price" value="{{ $productPrice }}">
                                    <input type="hidden" name="image" value="{{ $product->photo }}">
                                    <input type="hidden" name="buttonValue" value="addtocart">
                                    <input type="hidden" name="quant[1]" value="1">


                                    <button class="lpx-cart" type="submit" aria-label="Add to cart">
                                        <span class="lpx-cart-icon">
                                            <i class="fa fa-shopping-bag"></i>
                                        </span>
                                        <span class="lpx-cart-text">Add to Cart</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="lpx-card-content">
                            <div class="lpx-card-small-info">
                                <span
                                    class="lpx-category">{{ $product->subcategoryname ?? $product->categoryname }}</span>
                            </div>
                            <a href="{{ $productUrl }}" class="lpx-product-name">
                                {{ $product->productname }}
                            </a>
                            <div class="lpx-price-row">
                                <div class="lpx-price">
                                    <strong>₹{{ number_format($productPrice, 0) }}</strong>
                                    @if ($discount > 0)
                                        <del>₹{{ number_format($product->rate, 0) }}</del>
                                        <span class="lpx-discount">{{ $discount }}% OFF</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="lpx-bottom-cta">
                <a href="{{ route('FrontProduct') }}">
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
                    @foreach ($ourClients as $client)
                        <div class="lc-logo-item">
                            <img src="{{ asset('uploads/clients/' . $client->image) }}"
                                alt="{{ $client->name ?? 'Client' }}">
                        </div>
                    @endforeach

                    <!-- Duplicate Set for Infinite Slider -->
                    @foreach ($ourClients as $client)
                        <div class="lc-logo-item">
                            <img src="{{ asset('uploads/clients/' . $client->image) }}"
                                alt="{{ $client->name ?? 'Client' }}">
                        </div>
                    @endforeach

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
                            @foreach ($testimonials as $testimonial)
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
                                    <div class="lc-card-top">

                                    </div>

                                    <p class="lc-review-text">
                                        {{ $testimonial->description }}
                                    </p>

                                    <div class="lc-review-footer">
                                        <div class="lc-review-user">
                                            <div>
                                                <strong>{{ $testimonial->name }}</strong>
                                                <span>{{ $testimonial->tag }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | CATEGORY TABS
            |--------------------------------------------------------------------------
            */

            const categoryTabs = document.querySelectorAll('.category-tab');

            const categoryPanel = document.querySelector('#dynamic-category-panel');

            const swiperElement = document.querySelector(
                '#dynamic-category-panel .subcategory-swiper'
            );

            const nextButton = document.querySelector(
                '#dynamic-category-panel .category-next'
            );

            const prevButton = document.querySelector(
                '#dynamic-category-panel .category-prev'
            );


            /*
            |--------------------------------------------------------------------------
            | INITIALIZE SWIPER
            |--------------------------------------------------------------------------
            */

            let categorySwiper = null;

            if (swiperElement) {

                categorySwiper = new Swiper(swiperElement, {

                    slidesPerView: 1.3,

                    spaceBetween: 14,

                    speed: 650,

                    grabCursor: true,

                    watchOverflow: true,

                    observer: true,

                    observeParents: true,

                    navigation: {
                        nextEl: nextButton,
                        prevEl: prevButton
                    },

                    breakpoints: {

                        480: {
                            slidesPerView: 2.1,
                            spaceBetween: 14
                        },

                        700: {
                            slidesPerView: 3.1,
                            spaceBetween: 16
                        },

                        950: {
                            slidesPerView: 4.2,
                            spaceBetween: 17
                        },

                        1200: {
                            slidesPerView: 5.2,
                            spaceBetween: 18
                        },

                        1450: {
                            slidesPerView: 6,
                            spaceBetween: 18
                        }

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | CATEGORY TAB CLICK
            |--------------------------------------------------------------------------
            */

            categoryTabs.forEach(function(tab) {

                tab.addEventListener('click', function(e) {

                    e.preventDefault();

                    const categoryId = this.getAttribute('data-category');

                    console.log('Selected category:', categoryId);


                    /*
                    | Active tab
                    */

                    categoryTabs.forEach(function(item) {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');


                    /*
                    | Keep panel visible
                    */

                    if (categoryPanel) {
                        categoryPanel.classList.add('active');
                        categoryPanel.style.display = '';
                    }


                    /*
                    | AJAX request
                    */

                    fetch(
                            "{{ route('front.getSubCategories') }}?category_id=" +
                            encodeURIComponent(categoryId), {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            }
                        )

                        .then(function(response) {

                            if (!response.ok) {
                                throw new Error(
                                    'HTTP Error: ' + response.status
                                );
                            }

                            return response.json();

                        })

                        .then(function(data) {

                            console.log('AJAX data:', data);


                            if (!data.status) {
                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | CATEGORY TITLE
                            |--------------------------------------------------------------------------
                            */

                            const title =
                                document.querySelector('#category-title');

                            if (title && data.category) {

                                title.textContent =
                                    data.category.categoryname.toUpperCase() +
                                    ' COLLECTION';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | CATEGORY DESCRIPTION
                            |--------------------------------------------------------------------------
                            */

                            const description =
                                document.querySelector('#category-description');

                            if (description && data.category) {

                                description.textContent =
                                    data.category.meta_description || '';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | SUBCATEGORY
                            |--------------------------------------------------------------------------
                            */

                            const wrapper =
                                document.querySelector('#subcategory-wrapper');

                            if (!wrapper) {
                                return;
                            }


                            let slides = [];


                            if (
                                data.subCategories &&
                                data.subCategories.length > 0
                            ) {

                                data.subCategories.forEach(function(item) {

                                    slides.push(`
                            <div class="swiper-slide">

                                <a href="/products/${item.slugname}" class="subcategory-card">

                                    <div class="subcategory-image">

                                        <img
                                            src="{{ asset('Category') }}/${item.photo}"
                                            alt="${item.categoryname}"
                                        >

                                        <div class="subcategory-content">

                                            <div>

                                                <small>
                                                    ${item.meta_description || ''}
                                                </small>

                                                <h4>
                                                    ${item.categoryname}
                                                </h4>

                                            </div>

                                            <span class="subcategory-card-arrow">
                                                <i class="fa fa-long-arrow-right"></i>
                                            </span>

                                        </div>

                                    </div>

                                </a>

                            </div>
                        `);

                                });

                            } else {

                                slides.push(`
                        <div class="swiper-slide">

                            <div style="padding:40px;text-align:center;">
                                No subcategories found.
                            </div>

                        </div>
                    `);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | UPDATE SWIPER
                            |--------------------------------------------------------------------------
                            */

                            if (categorySwiper) {

                                categorySwiper.removeAllSlides();

                                categorySwiper.appendSlide(slides);

                                categorySwiper.update();

                                categorySwiper.slideTo(0);

                            } else {

                                wrapper.innerHTML = slides.join('');

                            }

                        })

                        .catch(function(error) {

                            console.error(
                                'Category AJAX error:',
                                error
                            );

                        });

                });

            });

        });
    </script>
@endsection
