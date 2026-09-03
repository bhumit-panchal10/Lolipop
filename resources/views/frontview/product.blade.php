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
                            <select id="lshopSort" name="sort">
                                <option value="featured" @selected(request('sort', 'featured') === 'featured')>Featured</option>
                                <option value="low" @selected(request('sort') === 'low')>Price: Low to High</option>
                                <option value="high" @selected(request('sort') === 'high')>Price: High to Low</option>
                                <option value="discount" @selected(request('sort') === 'discount')>Highest Discount</option>
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
                        {{--  <div class="lshop-filter-group lshop-filter-category">
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

                                    @foreach ($categories as $category)

                                        <label class="lshop-check-row">

                                            <input type="checkbox" class="lshop-category-filter" name="category[]"
                                                value="{{ $category->categoryId }}" data-parent="1"
                                                @checked(in_array($category->categoryId, (array) request('category', [])))>

                                            <span class="lshop-check-box"></span>

                                            <span class="lshop-check-label">
                                                {{ $category->categoryname }}
                                            </span>

                                        </label>



                                        @foreach ($subCategories as $subcategory)
                                            <label class="lshop-check-row lshop-subcategory-row">

                                                <input type="checkbox" class="lshop-category-filter" name="subcategory[]"
                                                    value="{{ $subcategory->categoryId }}" @checked(in_array($subcategory->categoryId, (array) request('subcategory', [])))
                                                    data-parent="{{ $category->categoryId }}">

                                                <span class="lshop-check-box"></span>

                                                <span class="lshop-check-label">
                                                    {{ $subcategory->categoryname }}
                                                </span>

                                                @php
                                                    $subProductCount = DB::table('product')
                                                        ->where('categoryId', $category->categoryId)
                                                        ->where('subcategoryid', $subcategory->categoryId)
                                                        ->where('iStatus', 1)
                                                        ->where('isDelete', 0)
                                                        ->count();
                                                @endphp

                                                <small>
                                                    {{ str_pad($subProductCount, 2, '0', STR_PAD_LEFT) }}
                                                </small>

                                            </label>
                                        @endforeach
                                    @endforeach

                                </div>

                            </div>
                        </div>  --}}
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
                                    <input type="checkbox" class="lshop-price-filter" name="price[]" value="0-500"
                                        @checked(in_array('0-500', (array) request('price', []), true))>
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        Under ₹500
                                    </span>
                                </label>
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" name="price[]" value="500-1000"
                                        @checked(in_array('500-1000', (array) request('price', []), true))>
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        ₹500 – ₹1,000
                                    </span>
                                </label>
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" name="price[]" value="1000-1500"
                                        @checked(in_array('1000-1500', (array) request('price', []), true))>
                                    <span class="lshop-check-box"></span>
                                    <span class="lshop-check-label">
                                        ₹1,000 – ₹1,500
                                    </span>
                                </label>
                                <label class="lshop-check-row">
                                    <input type="checkbox" class="lshop-price-filter" name="price[]" value="1500-999999"
                                        @checked(in_array('1500-999999', (array) request('price', []), true))>
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

                                    @foreach ($sizes as $size)
                                        <button type="button"
                                            class="lshop-size-btn {{ in_array((string) $size, array_map('strval', (array) request('size', [])), true) ? 'active' : '' }}"
                                            data-size="{{ $size }}">
                                            {{ $size }}
                                        </button>
                                    @endforeach

                                </div>

                                {{--  <div class="lshop-size-filter">
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
                                </div>  --}}
                            </div>
                            <div class="lshop-filter-apply">

                                <button type="button" class="lshop-filter-action" id="lshopApplyFilters">
                                    Apply Filters
                                </button>

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

                            @forelse($Product as $product)
                                @php
                                    $category = $categories->firstWhere('categoryId', $product->categoryId);

                                    $subcategory = $subCategories->firstWhere('categoryId', $product->subcategoryid);

                                    $productPrice = $product->product_attribute_price ?? ($product->rate ?? 0);

                                    // Product image path
                                    $productImage = $product->photo
                                        ? asset('/Product/Thumbnail/' . $product->photo)
                                        : asset('assets/images/no-image.jpg');

                                    // Calculate discount if required
                                    $discount = 0;

                                    if ($product->rate > 0 && $productPrice < $product->rate) {
                                        $discount = round((($product->rate - $productPrice) / $product->rate) * 100);
                                    }
                                @endphp


                                <article class="lshop-card" data-category="{{ $product->categoryId }}"
                                    data-subcategory="{{ $product->subcategoryid }}" data-price="{{ $productPrice }}"
                                    data-discount="{{ $discount }}">

                                    {{-- PRODUCT IMAGE --}}
                                    <div class="lshop-card-image">

                                        <a
                                            href="{{ route('productdetail.slugs', [$subcategory->slugname ?? $category->slugname, $product->slugname]) }}">

                                            <img src="{{ $productImage }}" alt="{{ $product->productname }}"
                                                class="lshop-card-img-main">

                                            @php
                                                $secondImage = DB::table('productphotos')
                                                    ->where('productid', $product->productId)
                                                    ->skip(1)
                                                    ->first();
                                            @endphp

                                            @if ($secondImage)
                                                <img src="{{ asset('/Product/Thumbnail/' . $secondImage->strphoto) }}"
                                                    alt="{{ $product->productname }}" class="lshop-card-img-hover">
                                            @else
                                                <img src="{{ $productImage }}" alt="{{ $product->productname }}"
                                                    class="lshop-card-img-hover">
                                            @endif

                                        </a>


                                        {{-- BADGE --}}
                                        @if ($discount > 0)
                                            <span class="lshop-card-badge">
                                                {{ $discount }}% OFF
                                            </span>
                                        @endif


                                        {{-- ACTIONS --}}
                                        <div class="lshop-card-actions">

                                            {{--  <button type="button" class="lshop-wishlist" aria-label="Wishlist">
                                                <i class="fa fa-heart-o"></i>
                                            </button>  --}}

                                            <form action="{{ route('cart.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="attributeid"
                                                    value="{{ $product->lowest_attribute_id }}">
                                                <input type="hidden" name="product_attribute_size"
                                                    value="{{ $product->lowest_attribute_size }}">
                                                <input type="hidden" name="productid"
                                                    value="{{ $product->productId }}">
                                                <input type="hidden" name="categoryId"
                                                    value="{{ $product->categoryId }}">
                                                <input type="hidden" name="subcategoryid"
                                                    value="{{ $product->subcategoryid }}">
                                                <input type="hidden" name="productslug"
                                                    value="{{ $product->slugname }}">
                                                <input type="hidden" name="categoryslug"
                                                    value="{{ $subcategory->slugname ?? $category->slugname }}">
                                                <input type="hidden" name="categoryname"
                                                    value="{{ $subcategory->categoryname ?? $category->categoryname }}">
                                                <input type="hidden" name="productname"
                                                    value="{{ $product->productname }}">
                                                <input type="hidden" name="price" value="{{ $productPrice }}">
                                                <input type="hidden" name="image" value="{{ $product->photo }}">
                                                <input type="hidden" name="buttonValue" value="addtocart">
                                                <input type="hidden" name="quant[1]" value="1">
                                                <button type="submit" class="lshop-cart" aria-label="Add to cart">
                                                    <i class="fa fa-shopping-bag"></i>
                                                </button>
                                            </form>

                                        </div>

                                    </div>


                                    {{-- PRODUCT CONTENT --}}
                                    <div class="lshop-card-content">

                                        <span class="lshop-card-category">

                                            {{ $category->categoryname ?? '' }}

                                            @if ($subcategory)
                                                • {{ $subcategory->categoryname }}
                                            @endif

                                        </span>


                                        <a href="{{ route('productdetail.slugs', [$subcategory->slugname ?? $category->slugname, $product->slugname]) }}"
                                            class="lshop-card-name">
                                            {{ $product->productname }}
                                        </a>


                                        {{-- PRICE --}}
                                        <div class="lshop-card-price">

                                            <strong>
                                                ₹{{ number_format($productPrice, 0) }}
                                            </strong>


                                            @if ($product->rate > $productPrice)
                                                <del>
                                                    ₹{{ number_format($product->rate, 0) }}
                                                </del>

                                                <span>
                                                    {{ $discount }}% OFF
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                </article>

                            @empty

                                <div class="lshop-empty show" id="lshopEmpty">

                                    <span>
                                        <i class="fa fa-search"></i>
                                    </span>

                                    <h3>
                                        No Products Found
                                    </h3>

                                    <p>
                                        No products are available in this category.
                                    </p>

                                    <button type="button" class="lshop-filter-action" id="lshopEmptyClear">
                                        Clear Filters
                                    </button>

                                </div>
                            @endforelse

                        </div>
                        {{--  <div class="lshop-product-grid" id="lshopProductGrid">
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

                        </div>  --}}
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
                            <button type="button" class="lshop-filter-action" id="lshopEmptyClear">
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
    <script>
        (() => {
            const pageUrl = new URL(window.location.href);
            let activeRequest;

            const getFilterUrl = () => {
                const params = new URLSearchParams();
                const sort = document.getElementById('lshopSort').value;

                if (sort !== 'featured') params.set('sort', sort);
                document.querySelectorAll('.lshop-category-filter:checked').forEach((input) => {
                    params.append(input.name, input.value);
                });
                document.querySelectorAll('.lshop-price-filter:checked').forEach((input) => {
                    params.append(input.name, input.value);
                });
                document.querySelectorAll('.lshop-size-btn.active').forEach((button) => {
                    params.append('size[]', button.dataset.size);
                });

                return `${pageUrl.pathname}?${params.toString()}`;
            };

            const applyFilters = async () => {
                const filterUrl = getFilterUrl();
                activeRequest?.abort();
                activeRequest = new AbortController();
                document.getElementById('lshopProductGrid')?.classList.add('is-loading');

                try {
                    const response = await fetch(filterUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: activeRequest.signal
                    });

                    if (!response.ok) throw new Error('Unable to load products');

                    const html = await response.text();
                    const nextGrid = new DOMParser()
                        .parseFromString(html, 'text/html')
                        .querySelector('#lshopProductGrid');

                    if (!nextGrid) throw new Error('Product grid not found');

                    document.getElementById('lshopProductGrid').replaceWith(nextGrid);
                    window.history.pushState({}, '', filterUrl);
                } catch (error) {
                    if (error.name !== 'AbortError') window.location.href = filterUrl;
                } finally {
                    activeRequest = null;
                }
            };

            document.querySelectorAll('.lshop-size-btn').forEach((button) => {
                button.addEventListener('click', () => button.classList.toggle('active'));
            });
            document.getElementById('lshopApplyFilters')?.addEventListener('click', applyFilters);
            document.getElementById('lshopClear')?.addEventListener('click', () => {
                window.location.href = pageUrl.pathname;
            });
            document.addEventListener('click', (event) => {
                if (event.target.closest('#lshopEmptyClear')) window.location.href = pageUrl.pathname;
            });
        })();
    </script>
@endsection
