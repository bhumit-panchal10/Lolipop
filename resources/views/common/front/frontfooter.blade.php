 <footer class="wonder-footer">
     <!-- SCALLOP TOP -->
     <div class="wonder-scallop" aria-hidden="true"></div>
     <div class="wonder-main">
         <div class="container">
             <!-- TOP STORY -->
             <div class="wonder-story">
                 <div class="wonder-copy">
                     <span class="wonder-kicker">MADE FOR LITTLE ADVENTURES</span>
                     <h2>
                         Wear happy.<br>
                         <em>Grow colourful.</em>
                     </h2>
                     <p>
                         Soft fabrics, playful colours and easy everyday styles designed
                         for busy little people with big personalities.
                     </p>
                     <a href="{{ url('products') }}" class="wonder-shop-btn">
                         Shop New Arrivals
                         <span>
                             <i class="fa fa-long-arrow-right"></i>
                         </span>
                     </a>
                 </div>
                 <!-- 3 CATEGORY VISUALS -->
                 @php
                     $categories = DB::table('category')
                         ->where('subcategoryid', 0)
                         ->where('iStatus', 1)
                         ->where('isDelete', 0)
                         ->orderByRaw("FIELD(slugname, 'girls-wear', 'boys-wear', 'discounted-outfit')")
                         ->get();
                 @endphp

                 <div class="wonder-categories">

                     @foreach ($categories as $category)
                         @php
                             $cardClass = match ($category->slugname) {
                                 'girls-wear' => 'wonder-girls',
                                 'boys-wear' => 'wonder-boys',
                                 'discounted-outfit' => 'wonder-baby',
                                 default => 'wonder-baby',
                             };
                         @endphp

                         <a href="{{ url('products') }}" class="wonder-card {{ $cardClass }}">

                             <img src="{{ asset('Category/' . $category->photo) }}"
                                 alt="{{ $category->categoryname }} collection">

                             <span class="wonder-card-overlay"></span>

                             <div class="wonder-card-content">

                                 <small>{{ $category->meta_title }}</small>

                                 <strong>{{ $category->categoryname }}</strong>

                                 <span>Explore →</span>

                             </div>

                         </a>
                     @endforeach

                 </div>

                 {{--  <div class="wonder-categories">
                     <a href="#" class="wonder-card wonder-girls">
                         <img src="assets/images/menu-girls.png" alt="Girls collection">
                         <span class="wonder-card-overlay"></span>
                         <div class="wonder-card-content">
                             <small>TWIRL & PLAY</small>
                             <strong>Girls</strong>
                             <span>Explore →</span>
                         </div>
                     </a>
                     <a href="#" class="wonder-card wonder-boys">
                         <img src="assets/images/menu-boys.png" alt="Boys collection">
                         <span class="wonder-card-overlay"></span>
                         <div class="wonder-card-content">
                             <small>MOVE & EXPLORE</small>
                             <strong>Boys</strong>
                             <span>Explore →</span>
                         </div>
                     </a>
                     <a href="#" class="wonder-card wonder-baby">
                         <img src="assets/images/menu-baby.png" alt="Baby collection">
                         <span class="wonder-card-overlay"></span>
                         <div class="wonder-card-content">
                             <small>SOFT & SNUG</small>
                             <strong>Baby</strong>
                             <span>Explore →</span>
                         </div>
                     </a>
                 </div>  --}}
             </div>
             <!-- INFO AREA -->
             <div class="wonder-info">
                 <!-- BRAND -->
                 <div class="wonder-brand">
                     <a href="{{ route('FrontIndex') }}" class="wonder-logo">
                         <img src="{{ asset('/Front/assets/images/lolipop-logo-new.png') }}" alt="Lolipop Kidswear">
                     </a>
                     <p>
                         Colourful kidswear for school days, party days, play days
                         and every happy moment in between.
                     </p>
                     <div class="wonder-socials">
                         <a href="#" aria-label="Instagram">
                             <svg viewBox="0 0 24 24">
                                 <rect x="3" y="3" width="18" height="18" rx="5" />
                                 <circle cx="12" cy="12" r="4" />
                                 <circle cx="17.5" cy="6.5" r="1" class="fill" />
                             </svg>
                         </a>
                         <a href="#" aria-label="Facebook">
                             <svg viewBox="0 0 24 24">
                                 <path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v5h4v-5h3l1-4h-4V9c0-.7.3-1 1-1Z" />
                             </svg>
                         </a>
                         <a href="#" aria-label="Pinterest">
                             <svg viewBox="0 0 24 24">
                                 <path d="M12 3a9 9 0 1 0 9 9c0-5-4-9-9-9Z" />
                                 <path
                                     d="M10 19c1-3 2-6 2.5-9 .2-1 1-2 2-2 1.2 0 1.8 1 1.5 2.2-.5 2-1.8 4.5-4 4.5-1.3 0-2.3-.8-2.3-2.2 0-2.4 2-5 5.3-5" />
                             </svg>
                         </a>
                     </div>
                 </div>
                 <!-- LINKS -->
                 <div class="wonder-links">
                     <h3>Shop</h3>

                     @foreach ($categories as $category)
                         <a href="{{ url('products') }}">{{ $category->categoryname }}</a>
                     @endforeach

                     {{--  <a href="#">Girls</a>
                     <a href="#">Boys</a>
                     <a href="#">Baby</a>
                     <a href="#">New Arrivals</a>  --}}
                 </div>
                 <div class="wonder-links">
                     <h3>Explore</h3>
                     <a href="{{ route('Frontaboutus') }}">About Us</a>
                     {{--  <a href="#">Blog</a>  --}}
                     <a href="{{ route('FrontContactUs') }}">Contact Us</a>
                 </div>
                 <div class="wonder-links">
                     <h3>Help</h3>
                     <a href="{{ route('Fronttrackorder') }}">Track Order</a>
                     {{--  <a href="#">Shipping</a>
                     <a href="#">Returns & Exchange</a>
                     <a href="#">Size Guide</a>
                     <a href="#">FAQs</a>  --}}
                 </div>
                 <!-- CONTACT INFORMATION -->
                 <div class="wonder-contact-card">
                     <span class="wonder-contact-tag">
                         GET IN TOUCH
                     </span>
                     <h3>
                         Lolipop Children Wear
                     </h3>
                     <div class="wonder-contact-list">
                         <!-- PHONE -->
                         <a href="tel:+919773201361" class="wonder-contact-item">
                             <span class="wonder-contact-icon wonder-contact-phone">
                                 <i class="fa fa-phone"></i>
                             </span>
                             <span class="wonder-contact-copy">
                                 <small>
                                     Call Us
                                 </small>
                                 <strong>
                                     97732 01361
                                 </strong>
                             </span>
                             <span class="wonder-contact-arrow">
                                 <i class="fa fa-long-arrow-right"></i>
                             </span>
                         </a>
                         <!-- EMAIL -->
                         <a href="mailto:firefashion313@gmail.com" class="wonder-contact-item">
                             <span class="wonder-contact-icon wonder-contact-email">
                                 <i class="fa fa-envelope-o"></i>
                             </span>
                             <span class="wonder-contact-copy">
                                 <small>
                                     Email Us
                                 </small>
                                 <strong>
                                     firefashion313@gmail.com
                                 </strong>
                             </span>
                             <span class="wonder-contact-arrow">
                                 <i class="fa fa-long-arrow-right"></i>
                             </span>
                         </a>
                         <!-- ADDRESS -->
                         <div class="wonder-contact-item wonder-contact-address">
                             <span class="wonder-contact-icon wonder-contact-location">
                                 <i class="fa fa-map-marker"></i>
                             </span>
                             <span class="wonder-contact-copy">
                                 <small>
                                     Visit Our Store
                                 </small>
                                 <strong>
                                     F-1, Gold Plaza, Opp. HDFC Bank,
                                     Navjivan Mill Compound,
                                     Kalol, Gujarat 382721.
                                 </strong>
                             </span>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- BOTTOM -->
             <div class="wonder-bottom">
                 <p>© 2026 Lolipop Kidswear. All rights reserved.</p>
                 <div class="wonder-policy">

                     <li><a href="{{ route('privacypolicy') }}">Privacy Policy</a></li>
                     <span></span>
                     <li><a href="{{ route('CancellationandRefund') }}">Cancellation and Refund</a></li>
                     <span></span>
                     <li><a href="{{ route('termandcondition') }}">Terms & Conditions</a></li>
                     <span></span>
                     <li><a href="{{ route('ShippingandDelivery') }}">Shipping and Delivery</a></li>
                     <span></span>
                     <li><a href="{{ route('noReturnNoExchange') }}">No Return - No Exchange</a></li>
                 </div>

             </div>
         </div>
     </div>
     <div class="wonder-colour-bar" aria-hidden="true">
         <span></span>
         <span></span>
         <span></span>
         <span></span>
         <span></span>
     </div>
 </footer>
