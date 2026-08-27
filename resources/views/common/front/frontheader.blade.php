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
                 <a href="index.html" class="nav-link active">Home</a>
                 <!-- GIRLS -->
                 <div class="nav-parent">
                     <button class="nav-link nav-btn" type="button">
                         Girls
                         <svg viewBox="0 0 16 16">
                             <path d="m4 6 4 4 4-4" />
                         </svg>
                     </button>
                     <div class="mega-menu">
                         <div class="mega-shell girls-shell">
                             <div class="mega-accent"></div>
                             <!-- LEFT FEATURE -->
                             <div class="fashion-feature pink-feature">
                                 <img class="feature-model" src="assets/images/menu-girls.png" alt="Girls collection">
                                 <h3>Pretty. Playful.<br>Perfectly Her.</h3>
                                 <p>Fresh everyday looks, festive favourites and twirl-ready
                                     dresses.</p>
                                 <a href="product.html" class="feature-link">
                                     Shop all Girls
                                     <b>→</b>
                                 </a>
                                 <span class="bubble bubble-1"></span>
                                 <span class="bubble bubble-2"></span>
                                 <span class="bubble bubble-3"></span>
                             </div>
                             <!-- CENTER -->
                             <div class="mega-main">
                                 <div class="mega-main-head">
                                     <div>
                                         <small>SHOP BY STYLE</small>
                                         <h4>What are we wearing today?</h4>
                                     </div>
                                     <a href="product.html">View all Girls →</a>
                                 </div>
                                 <div class="style-grid">
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-pink"><svg viewBox="0 0 24 24">
                                                 <path d="M9 4h6l1 4 4 10H4L8 8l1-4Z" />
                                                 <path d="M9 4c.5 1.6 1.5 2.4 3 2.4S14.5 5.6 15 4" />
                                             </svg></span>
                                         <strong>Dresses</strong>
                                         <small>Everyday & party</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-blue"><svg viewBox="0 0 24 24">
                                                 <path
                                                     d="M8 5 4 8l2 4 2-1v8h8v-8l2 1 2-4-4-3c-.7 1.2-2 2-4 2s-3.3-.8-4-2Z" />
                                             </svg></span>
                                         <strong>Tops & T-Shirts</strong>
                                         <small>Easy favourites</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-green"><svg viewBox="0 0 24 24">
                                                 <path d="M7 5h10l-1 14h-4l-1-8-1 8H6L7 5Z" />
                                             </svg></span>
                                         <strong>Bottom Wear</strong>
                                         <small>Jeans, skirts & shorts</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-orange"><svg viewBox="0 0 24 24">
                                                 <path d="M7 5 4 8l2 3 2-1v5h8v-5l2 1 2-3-3-3" />
                                                 <path d="M8 16h3l1 3 1-3h3" />
                                             </svg></span>
                                         <strong>Co-ord Sets</strong>
                                         <small>Ready-made looks</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-yellow"><svg viewBox="0 0 24 24">
                                                 <path d="M17.5 15.5A7 7 0 0 1 8.5 6a7 7 0 1 0 9 9.5Z" />
                                                 <path d="m15 5 .5 1.5L17 7l-1.5.5L15 9l-.5-1.5L13 7l1.5-.5L15 5Z" />
                                             </svg></span>
                                         <strong>Nightwear</strong>
                                         <small>Soft & comfy</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-pink"><svg viewBox="0 0 24 24">
                                                 <path d="M9 5h6l3 3-2 3-1-1v9H9v-9l-1 1-2-3 3-3Z" />
                                                 <path d="M10 5c.4 1.1 1.1 1.7 2 1.7S13.6 6.1 14 5" />
                                             </svg></span>
                                         <strong>Winter Wear</strong>
                                         <small>Warm little layers</small>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- BOYS -->
                 <div class="nav-parent">
                     <button class="nav-link nav-btn" type="button">
                         Boys
                         <svg viewBox="0 0 16 16">
                             <path d="m4 6 4 4 4-4" />
                         </svg>
                     </button>
                     <div class="mega-menu">
                         <div class="mega-shell boys-shell">
                             <div class="mega-accent"></div>
                             <div class="fashion-feature blue-feature">
                                 <img class="feature-model" src="assets/images/menu-boys.png" alt="Boys collection">
                                 <h3>Cool. Comfy.<br>Ready to Move.</h3>
                                 <p>Smart casuals, relaxed basics and festive looks for
                                     little explorers.</p>
                                 <a href="product.html" class="feature-link">
                                     Shop all Boys
                                     <b>→</b>
                                 </a>
                                 <span class="bubble bubble-1"></span>
                                 <span class="bubble bubble-2"></span>
                                 <span class="bubble bubble-3"></span>
                             </div>
                             <div class="mega-main">
                                 <div class="mega-main-head">
                                     <div>
                                         <small>SHOP BY STYLE</small>
                                         <h4>Built for busy little days</h4>
                                     </div>
                                     <a href="product.html">View all Boys →</a>
                                 </div>
                                 <div class="style-grid">
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-blue"><svg viewBox="0 0 24 24">
                                                 <path
                                                     d="M8 5 4 8l2 4 2-1v8h8v-8l2 1 2-4-4-3c-.7 1.2-2 2-4 2s-3.3-.8-4-2Z" />
                                             </svg></span>
                                         <strong>T-Shirts</strong>
                                         <small>Everyday cool</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-green"><svg viewBox="0 0 24 24">
                                                 <path d="M8 5 5 8l2 3 2-1v9h6v-9l2 1 2-3-3-3" />
                                                 <path d="m10 5 2 2 2-2" />
                                                 <path d="M12 7v12" />
                                             </svg></span>
                                         <strong>Shirts</strong>
                                         <small>Smart & casual</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-green"><svg viewBox="0 0 24 24">
                                                 <path d="M7 5h10l-1 14h-4l-1-8-1 8H6L7 5Z" />
                                             </svg></span>
                                         <strong>Bottom Wear</strong>
                                         <small>Jeans & trousers</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-yellow"><svg viewBox="0 0 24 24">
                                                 <path d="M7 6h10l1 11h-5l-1-4-1 4H6L7 6Z" />
                                                 <path d="M7 9h10" />
                                             </svg></span>
                                         <strong>Shorts</strong>
                                         <small>Playtime ready</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-orange"><svg viewBox="0 0 24 24">
                                                 <path d="M7 5 4 8l2 3 2-1v5h8v-5l2 1 2-3-3-3" />
                                                 <path d="M8 16h3l1 3 1-3h3" />
                                             </svg></span>
                                         <strong>Co-ord Sets</strong>
                                         <small>Easy matching looks</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-yellow"><svg viewBox="0 0 24 24">
                                                 <path d="M17.5 15.5A7 7 0 0 1 8.5 6a7 7 0 1 0 9 9.5Z" />
                                                 <path d="m15 5 .5 1.5L17 7l-1.5.5L15 9l-.5-1.5L13 7l1.5-.5L15 5Z" />
                                             </svg></span>
                                         <strong>Nightwear</strong>
                                         <small>Cosy bedtime</small>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- BABY -->
                 <div class="nav-parent">
                     <button class="nav-link nav-btn" type="button">
                         Baby
                         <svg viewBox="0 0 16 16">
                             <path d="m4 6 4 4 4-4" />
                         </svg>
                     </button>
                     <div class="mega-menu">
                         <div class="mega-shell baby-shell">
                             <div class="mega-accent"></div>
                             <div class="fashion-feature green-feature">
                                 <img class="feature-model" src="assets/images/menu-baby.png" alt="Baby collection">
                                 <h3>Soft. Sweet.<br>Made with Love.</h3>
                                 <p>Gentle newborn essentials and comfy styles for tiny
                                     adventures.</p>
                                 <a href="product.html" class="feature-link">
                                     Shop all Baby
                                     <b>→</b>
                                 </a>
                                 <span class="bubble bubble-1"></span>
                                 <span class="bubble bubble-2"></span>
                                 <span class="bubble bubble-3"></span>
                             </div>
                             <div class="mega-main">
                                 <div class="mega-main-head">
                                     <div>
                                         <small>BABY ESSENTIALS</small>
                                         <h4>Little things for little ones</h4>
                                     </div>
                                     <a href="product.html">View all Baby →</a>
                                 </div>
                                 <div class="style-grid">
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-blue"><svg viewBox="0 0 24 24">
                                                 <circle cx="12" cy="8" r="3" />
                                                 <path d="M7 19c.5-4 2.1-6 5-6s4.5 2 5 6" />
                                                 <path d="M15.5 4.5 18 3l-1 3" />
                                             </svg></span>
                                         <strong>Baby Boy</strong>
                                         <small>Little everyday looks</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-pink"><svg viewBox="0 0 24 24">
                                                 <circle cx="12" cy="8" r="3" />
                                                 <path d="M7 19c.5-4 2.1-6 5-6s4.5 2 5 6" />
                                                 <path d="M15.5 4.5 18 3l-1 3" />
                                                 <path d="m8 4 1.5 1" />
                                             </svg></span>
                                         <strong>Baby Girl</strong>
                                         <small>Sweet little styles</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-green"><svg viewBox="0 0 24 24">
                                                 <path d="M9 4h6l1 4 2 3-2 2v6h-3l-1-3-1 3H8v-6l-2-2 2-3 1-4Z" />
                                                 <path d="M10 4c.3 1 1 1.5 2 1.5S13.7 5 14 4" />
                                             </svg></span>
                                         <strong>Rompers</strong>
                                         <small>Soft & easy</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-orange"><svg viewBox="0 0 24 24">
                                                 <path d="M7 5 4 8l2 3 2-1v5h8v-5l2 1 2-3-3-3" />
                                                 <path d="M8 16h3l1 3 1-3h3" />
                                             </svg></span>
                                         <strong>Baby Sets</strong>
                                         <small>Complete comfy looks</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-yellow"><svg viewBox="0 0 24 24">
                                                 <path d="M9 4h6l1 4 2 3-2 2v6h-3l-1-3-1 3H8v-6l-2-2 2-3 1-4Z" />
                                                 <path d="M15 7h2" />
                                                 <path d="m17 5 .4 1 .9.3-.9.4L17 8l-.4-1.3-.9-.4.9-.3L17 5Z" />
                                             </svg></span>
                                         <strong>Sleepsuits</strong>
                                         <small>Cosy bedtime</small>
                                     </a>
                                     <a href="product.html" class="style-card">
                                         <span class="style-icon icon-pink"><svg viewBox="0 0 24 24">
                                                 <path d="M4 10h16v10H4V10Z" />
                                                 <path d="M3 7h18v3H3V7Z" />
                                                 <path d="M12 7v13" />
                                                 <path d="M12 7c-2-3-5-3-5-1 0 1.3 1.4 1.7 5 1" />
                                                 <path d="M12 7c2-3 5-3 5-1 0 1.3-1.4 1.7-5 1" />
                                             </svg></span>
                                         <strong>Gift Sets</strong>
                                         <small>Made for gifting</small>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- COLLECTIONS -->
                 <div class="nav-parent">
                     <button class="nav-link nav-btn" type="button">
                         Collections
                         <svg viewBox="0 0 16 16">
                             <path d="m4 6 4 4 4-4" />
                         </svg>
                     </button>
                     <div class="collection-dropdown">
                         <div class="collection-shell">
                             <div class="collection-head">
                                 <div>
                                     <span class="collection-kicker">Discover Lolipop</span>
                                     <strong>Shop Collections</strong>
                                 </div>
                                 <a href="#" class="collection-view-all">
                                     View All
                                     <b>→</b>
                                 </a>
                             </div>
                             <div class="collection-grid">
                                 <a href="#" class="collection-card collection-best">
                                     <span class="collection-art">
                                         <svg viewBox="0 0 24 24">
                                             <path
                                                 d="m12 3 2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.5-4.8 2.5.9-5.4-3.9-3.8 5.4-.8L12 3Z" />
                                         </svg>
                                     </span>
                                     <span class="collection-copy">
                                         <small>Most Loved</small>
                                         <strong>Best Sellers</strong>
                                         <em>Shop favourites →</em>
                                     </span>
                                     <i class="collection-bubble"></i>
                                 </a>
                                 <a href="#" class="collection-card collection-summer">
                                     <span class="collection-art">
                                         <svg viewBox="0 0 24 24">
                                             <circle cx="12" cy="12" r="3.5" />
                                             <path
                                                 d="M12 2v3M12 19v3M2 12h3M19 12h3M4.9 4.9 7 7M17 17l2.1 2.1M19.1 4.9 17 7M7 17l-2.1 2.1" />
                                         </svg>
                                     </span>
                                     <span class="collection-copy">
                                         <small>Bright & Breezy</small>
                                         <strong>Summer Collection</strong>
                                         <em>Explore summer →</em>
                                     </span>
                                     <i class="collection-bubble"></i>
                                 </a>
                                 <a href="#" class="collection-card collection-winter">
                                     <span class="collection-art">
                                         <svg viewBox="0 0 24 24">
                                             <path
                                                 d="M12 2v20M4 7l16 10M20 7 4 17M8 4l4 3 4-3M8 20l4-3 4 3M3 11l4 1-1 4M21 11l-4 1 1 4" />
                                         </svg>
                                     </span>
                                     <span class="collection-copy">
                                         <small>Cosy Layers</small>
                                         <strong>Winter Collection</strong>
                                         <em>Stay cosy →</em>
                                     </span>
                                     <i class="collection-bubble"></i>
                                 </a>
                                 <a href="#" class="collection-card collection-festive">
                                     <span class="collection-art">
                                         <svg viewBox="0 0 24 24">
                                             <path
                                                 d="m12 3 1.2 3.3L16.5 7.5l-3.3 1.2L12 12l-1.2-3.3-3.3-1.2 3.3-1.2L12 3Z" />
                                             <path d="m18 13 .8 2.2L21 16l-2.2.8L18 19l-.8-2.2L15 16l2.2-.8L18 13Z" />
                                             <path d="m6 14 .7 1.8 1.8.7-1.8.7L6 19l-.7-1.8-1.8-.7 1.8-.7L6 14Z" />
                                         </svg>
                                     </span>
                                     <span class="collection-copy">
                                         <small>Celebrate in Style</small>
                                         <strong>Festive Collection</strong>
                                         <em>Dress festive →</em>
                                     </span>
                                     <i class="collection-bubble"></i>
                                 </a>
                                 <a href="#" class="collection-card collection-party">
                                     <span class="collection-art">
                                         <svg viewBox="0 0 24 24">
                                             <path d="M7 20 18 9" />
                                             <path d="m6 14 4 4-5 2 1-6Z" />
                                             <path d="M14 5c.5-1 1.3-2 2.6-2 .6 1.2.6 2.3 0 3.3" />
                                             <path d="M18 8c1-.5 2-.5 3 .2-.2 1.4-.9 2.2-2 2.7" />
                                             <circle cx="9" cy="7" r="1" />
                                             <circle cx="17" cy="15" r="1" />
                                         </svg>
                                     </span>
                                     <span class="collection-copy">
                                         <small>Dress-Up Moments</small>
                                         <strong>Party Collection</strong>
                                         <em>Party ready →</em>
                                     </span>
                                     <i class="collection-bubble"></i>
                                 </a>
                                 <a href="#" class="collection-card collection-everyday">
                                     <span class="collection-art">
                                         <svg viewBox="0 0 24 24">
                                             <path
                                                 d="M8 5 4 8l2 4 2-1v8h8v-8l2 1 2-4-4-3c-.7 1.2-2 2-4 2s-3.3-.8-4-2Z" />
                                         </svg>
                                     </span>
                                     <span class="collection-copy">
                                         <small>Easy Everyday</small>
                                         <strong>Daily Essentials</strong>
                                         <em>Shop everyday →</em>
                                     </span>
                                     <i class="collection-bubble"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
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
                 <a href="wishlist.html" class="icon-btn wishlist" aria-label="Wishlist">
                     <svg viewBox="0 0 24 24">
                         <path
                             d="M20.8 5.8c-1.7-1.9-4.6-1.9-6.4 0L12 8.2 9.6 5.8c-1.8-1.9-4.7-1.9-6.4 0-1.8 2-1.5 5 .4 6.8L12 21l8.4-8.4c1.9-1.8 2.2-4.8.4-6.8Z" />
                     </svg>
                 </a>
                 <a href="#" class="account-btn">
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
                 </a>
                 <a href="#" class="cart-btn">
                     <span class="cart-icon">
                         <svg viewBox="0 0 24 24">
                             <path d="M5 8h14l-1 12H6L5 8Z" />
                             <path d="M9 9V6a3 3 0 0 1 6 0v3" />
                         </svg>
                         <b>2</b>
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
