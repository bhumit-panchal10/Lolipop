 <header class="site-header">
     <!-- TOP BAR -->
     <div class="topbar">
         <div class="container topbar-inner">
             <div class="topbar-left">
                 <span class="pulse-dot"></span>
                 <span>Free shipping above ₹999</span>
                 <i></i>
                 <strong>Easy 7-day returns</strong>
             </div>
             <div class="topbar-right">
                 <a href="{{ route('Fronttrackorder') }}">Track Order</a>
                 <a href="#">Help</a>
             </div>
         </div>
     </div>
     <!-- MAIN HEADER -->
     <div class="main-header">
         <div class="container header-inner">
             <!-- LOGO -->
             <a href="{{ route('FrontIndex') }}" class="logo">
                 <img src="{{ asset('Front/assets/images/lolipop-logo.png') }}" alt="Lolipop Kidswear">
             </a>
             <!-- DESKTOP NAVIGATION -->
             <nav class="desktop-nav">
                 <a href="{{ route('FrontIndex') }}" class="nav-link active">Home</a>

                 @php
                     // Main categories
                     $categories = DB::table('category')->where('iStatus', 1)->where('subcategoryid', 0)->get();

                     // All subcategories
                     $subCategories = DB::table('category')
                         ->where('iStatus', 1)
                         ->where('subcategoryid', '>', 0)
                         ->get()
                         ->groupBy('subcategoryid');
                 @endphp


                 @foreach ($categories as $category)
                     @php
                         $children = $subCategories[$category->categoryId] ?? collect();
                     @endphp

                     <div class="nav-parent">

                         {{-- MAIN CATEGORY --}}
                         <button class="nav-link nav-btn" type="button">

                             {{ $category->categoryname }}

                             @if ($children->count() > 0)
                                 <svg viewBox="0 0 16 16">
                                     <path d="m4 6 4 4 4-4" />
                                 </svg>
                             @endif

                         </button>


                         {{-- DROPDOWN ONLY IF SUBCATEGORY EXISTS --}}
                         @if ($children->count() > 0)
                             <div class="mega-menu">

                                 <div class="mega-shell girls-shell">

                                     <div class="mega-accent"></div>

                                     {{-- LEFT FEATURE --}}
                                     <div class="fashion-feature pink-feature">

                                         @if ($category->photo)
                                             <img class="feature-model"
                                                 src="{{ asset('Category/' . $category->photo) }}"
                                                 alt="{{ $category->categoryname }}">
                                         @endif

                                         <h3>
                                             {{ $category->meta_title }}
                                         </h3>

                                         <p>
                                             {{ $category->meta_description }}
                                         </p>

                                         <a href="{{ url('product') }}" class="feature-link">
                                             Shop all {{ $category->categoryname }}
                                             <b>→</b>
                                         </a>

                                         <span class="bubble bubble-1"></span>
                                         <span class="bubble bubble-2"></span>
                                         <span class="bubble bubble-3"></span>

                                     </div>


                                     {{-- CENTER --}}
                                     <div class="mega-main">

                                         <div class="mega-main-head">

                                             <div>
                                                 <small>SHOP BY STYLE</small>

                                                 <h4>
                                                     What are we wearing today?
                                                 </h4>
                                             </div>

                                             <a href="{{ url('product') }}">
                                                 View all {{ $category->categoryname }} →
                                             </a>

                                         </div>


                                         {{-- SUBCATEGORIES --}}
                                         <div class="style-grid">

                                             @foreach ($children as $subcategory)
                                                 <a href="{{ route('FrontProduct', ['slug' => $subcategory->slugname]) }}"
                                                     class="style-card">

                                                     <span class="style-icon icon-pink">

                                                         @if ($subcategory->photo)
                                                             <img src="{{ asset('Category/' . $subcategory->photo) }}"
                                                                 alt="{{ $subcategory->categoryname }}"
                                                                 style="
                                                    width:50px;
                                                    height:50px;
                                                    object-fit:contain;
                                                ">
                                                         @endif

                                                     </span>


                                                     <strong>
                                                         {{ $subcategory->categoryname }}
                                                     </strong>


                                                     <small>
                                                         Shop {{ $subcategory->categoryname }}
                                                     </small>

                                                 </a>
                                             @endforeach

                                         </div>

                                     </div>

                                 </div>

                             </div>
                         @endif

                     </div>
                 @endforeach



                 <!-- <a href="#" class="nav-link simple-page-link">About Us</a>
          <a href="#" class="nav-link simple-page-link">Blog</a>
          <a href="#" class="nav-link simple-page-link">Contact Us</a> -->
             </nav>
             <!-- ACTIONS -->
             <div class="header-actions">
                 <button class="icon-btn search-trigger" type="button" aria-label="Search">
                     <svg viewBox="0 0 24 24">
                         <circle cx="11" cy="11" r="6" />
                         <path d="m16 16 4 4" />
                     </svg>
                 </button>

                 {{--  <a href="#" class="account-btn">
                     <span class="account-icon">
                         <svg viewBox="0 0 24 24">
                             <circle cx="12" cy="8" r="4" />
                             <path d="M5 20c.8-4 3.1-6 7-6s6.2 2 7 6" />
                         </svg>
                     </span>
                     <span class="account-copy">
                         <small>Hello</small>
                         <strong>Account</strong>
                     </span>
                 </a>  --}}
                 <a href="{{ route('cart.list') }}" class="cart-btn">
                     <span class="cart-icon">
                         <svg viewBox="0 0 24 24">
                             <path d="M5 8h14l-1 12H6L5 8Z" />
                             <path d="M9 9V6a3 3 0 0 1 6 0v3" />
                         </svg>
                         <b class="js-cart-count">{{ \Cart::getContent()->count() }}</b>
                     </span>
                 </a>
                 <button class="mobile-toggle" id="mobileToggle" type="button" aria-label="Menu">
                     <span></span>
                     <span></span>
                     <span></span>
                 </button>
             </div>
         </div>
     </div>
     <!-- COLOR LINE -->
     <div class="color-line">
         <span></span><span></span><span></span><span></span><span></span>
     </div>
     <!-- SEARCH PANEL -->
     <div class="search-panel" id="searchPanel">
         <div class="container search-inner">
             <form>
                 <svg viewBox="0 0 24 24">
                     <circle cx="11" cy="11" r="6" />
                     <path d="m16 16 4 4" />
                 </svg>
                 <input type="search" placeholder="Search dresses, t-shirts, baby wear...">
                 <button type="button" id="searchClose">Close</button>
             </form>
         </div>
     </div>
     <!-- MOBILE MENU -->
     <div class="mobile-menu" id="mobileMenu">
         <div class="container mobile-inner">
             <a href="#" class="mobile-link active">Home</a>
             <div class="mobile-group">
                 <button class="mobile-parent" type="button">Girls
                     <span>+</span></button>
                 <div class="mobile-sub">
                     <a href="#">Dresses</a>
                     <a href="#">Tops & T-Shirts</a>
                     <a href="#">Jeans & Trousers</a>
                     <a href="#">Shorts & Skirts</a>
                     <a href="#">Co-ord Sets</a>
                     <a href="#">Nightwear</a>
                     <a href="#">Ethnic Wear</a>
                     <a href="#">Party Wear</a>
                 </div>
             </div>
             <div class="mobile-group">
                 <button class="mobile-parent" type="button">Boys
                     <span>+</span></button>
                 <div class="mobile-sub">
                     <a href="#">T-Shirts</a>
                     <a href="#">Shirts</a>
                     <a href="#">Jeans & Trousers</a>
                     <a href="#">Shorts</a>
                     <a href="#">Co-ord Sets</a>
                     <a href="#">Nightwear</a>
                     <a href="#">Ethnic Wear</a>
                     <a href="#">Party Wear</a>
                 </div>
             </div>
             <div class="mobile-group">
                 <button class="mobile-parent" type="button">Baby
                     <span>+</span></button>
                 <div class="mobile-sub">
                     <a href="#">Baby Boy</a>
                     <a href="#">Baby Girl</a>
                     <a href="#">Rompers</a>
                     <a href="#">Baby Sets</a>
                     <a href="#">Sleepsuits</a>
                     <a href="#">Gift Sets</a>
                 </div>
             </div>
             <div class="mobile-group">
                 <button class="mobile-parent" type="button">Collections
                     <span>+</span></button>
                 <div class="mobile-sub">
                     <a href="#">Best Sellers</a>
                     <a href="#">Summer Collection</a>
                     <a href="#">Winter Collection</a>
                     <a href="#">Festive Collection</a>
                     <a href="#">Party Collection</a>
                 </div>
             </div>
             <!-- <a href="about-us.html" class="mobile-link">About Us</a>
        <a href="blog.html" class="mobile-link">Blog</a>
        <a href="contact-us.html" class="mobile-link">Contact Us</a>
        <a href="#" class="sale-link">
          Sale
          <span>40%</span>
        </a> -->
         </div>
     </div>
 </header>
