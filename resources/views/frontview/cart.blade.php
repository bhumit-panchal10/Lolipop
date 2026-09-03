@extends('layouts.front')
@section('title', 'Cart')
@section('content')

    @include('common.front.frontalert')
    <style>
        .lcart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 30px;
            align-items: start;
        }

        .lcart-items-area {
            min-width: 0;
        }

        .lcart-summary {
            width: 100%;
            position: sticky;
            top: 20px;
        }

        @media (max-width: 991px) {

            .lcart-layout {
                grid-template-columns: 1fr;
            }

            .lcart-summary {
                position: static;
                width: 100%;
            }

        }
    </style>
    <!-- =====================================================
                                                                         CART PAGE
                                                                    ====================================================== -->
    <main class="lcart-page">
        <section class="lcart-section">
            <div class="container">
                <!-- =================================================
                                                                                     PAGE TOP
                                                                                ================================================== -->
                <div class="lcart-page-head">
                    <div>
                        <span>
                            YOUR LITTLE PICKS
                        </span>
                        <h2>
                            Shopping
                            <em>Cart</em>
                        </h2>
                        <p>
                            Review your selected styles before checkout.
                        </p>
                    </div>
                    <a href="{{ url()->previous() }}" class="lcart-continue">
                        <i class="fa fa-long-arrow-left"></i>
                        Continue Shopping
                    </a>
                </div>
                <!-- =================================================
                                                                                     CART LAYOUT
                                                                                ================================================== -->
                <div class="lcart-layout">

                    <!-- LEFT -->
                    <div class="lcart-items-area">

                        <div class="lcart-items-head">
                            <div>
                                <strong>
                                    My Cart
                                </strong>

                                <span id="lcartItemCount">
                                    {{ $cartItems->sum('quantity') }}
                                    {{ $cartItems->sum('quantity') === 1 ? 'Item' : 'Items' }}
                                </span>
                            </div>

                            @if ($cartItems->isNotEmpty())
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf

                                    <button type="submit" id="lcartClearAll">
                                        <i class="fa fa-trash-o"></i>
                                        Clear Cart
                                    </button>
                                </form>
                            @endif
                        </div>


                        @foreach ($cartItems as $item)
                            <article class="lcart-item" data-price="{{ $item->price }}" data-item-id="{{ $item->id }}">

                                <a href="{{ $item->categoryslug && $item->productslug
                                    ? route('productdetail.slugs', [
                                        'subcategory' => $item->categoryslug,
                                        'product' => $item->productslug,
                                    ])
                                    : '#' }}"
                                    class="lcart-item-image">

                                    <img src="{{ asset('/Product/Thumbnail/' . ($item->attributes->image ?? '')) }}"
                                        alt="{{ $item->name }}">

                                </a>


                                <div class="lcart-item-info">

                                    <span class="lcart-item-category">
                                        {{ $item->categoryname ?? '' }}
                                    </span>


                                    <a href="{{ $item->categoryslug && $item->productslug
                                        ? route('productdetail.slugs', [
                                            'subcategory' => $item->categoryslug,
                                            'product' => $item->productslug,
                                        ])
                                        : '#' }}"
                                        class="lcart-item-name">

                                        {{ $item->name }}

                                    </a>


                                    <p>
                                        Size:
                                        <strong>{{ $item->size }}</strong>
                                    </p>


                                    <div class="lcart-mobile-price">
                                        <strong>
                                            ₹{{ number_format($item->price, 0) }}
                                        </strong>
                                    </div>


                                    <!-- QUANTITY -->
                                    <div class="lcart-item-bottom">

                                        <form action="{{ route('cart.update') }}" method="POST" class="lcart-quantity">

                                            @csrf

                                            <input type="hidden" name="id" value="{{ $item->id }}">


                                            <button type="submit" name="quantity"
                                                value="{{ max(1, $item->quantity - 1) }}" class="lcart-minus"
                                                aria-label="Decrease quantity">

                                                <i class="fa fa-minus"></i>

                                            </button>


                                            <input type="text" value="{{ $item->quantity }}" class="lcart-qty" readonly>


                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                                class="lcart-plus" aria-label="Increase quantity">

                                                <i class="fa fa-plus"></i>

                                            </button>

                                        </form>

                                        <!-- REMOVE -->
                                        <div class="lcart-item-actions">

                                            <form action="{{ route('cart.remove') }}" method="POST">

                                                @csrf

                                                <input type="hidden" name="id" value="{{ $item->id }}">

                                                <button type="submit" class="lcart-remove">

                                                    <i class="fa fa-trash-o"></i>
                                                    Remove

                                                </button>

                                            </form>

                                        </div>

                                    </div>




                                </div>


                                <!-- PRODUCT TOTAL -->
                                <div class="lcart-item-price">

                                    <strong class="lcart-line-total">

                                        ₹{{ number_format($item->price * $item->quantity, 0) }}

                                    </strong>

                                </div>

                            </article>
                        @endforeach


                        <!-- EMPTY -->
                        <div class="lcart-empty" id="lcartEmpty"
                            style="{{ $cartItems->isEmpty() ? '' : 'display: none;' }}">

                            <div class="lcart-empty-icon">
                                <i class="fa fa-shopping-bag"></i>
                            </div>

                            <h3>
                                Your cart is feeling a little empty!
                            </h3>

                            <p>
                                Add some colourful little favourites
                                and come back here.
                            </p>

                            <a href="product.html?gender=girls">
                                Start Shopping
                                <i class="fa fa-long-arrow-right"></i>
                            </a>

                        </div>

                    </div>


                    <!-- =====================================================
                                                     RIGHT ORDER SUMMARY
                                ====================================================== -->

                    <aside class="lcart-summary">

                        <div class="lcart-summary-head">

                            <span class="lcart-summary-icon">
                                <i class="fa fa-shopping-bag"></i>
                            </span>

                            <div>

                                <small>
                                    YOUR ORDER
                                </small>

                                <h3>
                                    Order Summary
                                </h3>

                            </div>

                        </div>


                        <div class="lcart-price-list">

                            <div>

                                <span>
                                    Subtotal
                                </span>

                                <strong id="lcartSubtotal">

                                    ₹{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 0) }}

                                </strong>

                            </div>


                            <div>

                                <span>
                                    Product Discount
                                </span>

                                <strong class="lcart-saving" id="lcartDiscount">

                                    - ₹0

                                </strong>

                            </div>


                            <div>

                                <span>
                                    Shipping
                                </span>

                                <strong class="lcart-free" id="lcartShipping">

                                    FREE

                                </strong>

                            </div>


                            <div class="lcart-coupon-row" id="lcartCouponRow">

                                <span>
                                    Coupon Discount
                                </span>

                                <strong id="lcartCouponDiscount">
                                    - ₹0
                                </strong>

                            </div>

                        </div>


                        <div class="lcart-total">

                            <div>

                                <span>
                                    Total Amount
                                </span>

                                <strong id="lcartGrandTotal">

                                    ₹{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 0) }}

                                </strong>

                            </div>

                            <small>
                                Inclusive of all taxes
                            </small>

                        </div>


                        {{--  <div class="lcart-save-box">

                            <span>
                                <i class="fa fa-smile-o"></i>
                            </span>

                            <p>

                                You are saving

                                <strong id="lcartSaving">
                                    ₹0
                                </strong>

                                on this order.

                            </p>

                        </div>  --}}


                        <a href="{{ route('checkout') }}" class="lcart-checkout">

                            <span>
                                <i class="fa fa-lock"></i>
                            </span>

                            <strong>
                                Proceed To Checkout
                            </strong>

                            <i class="fa fa-long-arrow-right"></i>

                        </a>

                    </aside>

                </div>
            </div>
            </div>
        </section>
    </main>

@endsection

@section('scripts')

@section('scripts')

    <script>
        (() => {

            const money = (value) => {
                return `₹${Number(value).toLocaleString('en-IN', {
            maximumFractionDigits: 0
        })}`;
            };

            const itemCount = document.getElementById('lcartItemCount');
            const subtotal = document.getElementById('lcartSubtotal');
            const grandTotal = document.getElementById('lcartGrandTotal');

            document.querySelectorAll('.lcart-quantity').forEach((form) => {

                form.addEventListener('submit', async (event) => {

                    event.preventDefault();

                    const button = event.submitter;

                    if (!button) {
                        return;
                    }

                    button.disabled = true;

                    try {

                        const formData = new FormData(form);

                        // Get the quantity from the button
                        const newQuantity = Number(button.value);

                        formData.set('quantity', newQuantity);

                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) {
                            throw new Error('Unable to update cart');
                        }

                        const data = await response.json();

                        const item = form.closest('.lcart-item');

                        /*
                        |--------------------------------------------------------------------------
                        | Current quantity
                        |--------------------------------------------------------------------------
                        */

                        const quantity = Number(data.quantity);

                        form.querySelector('.lcart-qty').value = quantity;


                        /*
                        |--------------------------------------------------------------------------
                        | IMPORTANT:
                        | Update minus button value
                        |--------------------------------------------------------------------------
                        */

                        const minusButton = form.querySelector('.lcart-minus');

                        if (minusButton) {
                            minusButton.value = Math.max(1, quantity - 1);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | IMPORTANT:
                        | Update plus button value
                        |--------------------------------------------------------------------------
                        */

                        const plusButton = form.querySelector('.lcart-plus');

                        if (plusButton) {
                            plusButton.value = quantity + 1;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Update product line total
                        |--------------------------------------------------------------------------
                        */

                        const price = Number(item.dataset.price);

                        item.querySelector('.lcart-line-total').textContent =
                            money(price * quantity);


                        /*
                        |--------------------------------------------------------------------------
                        | Update subtotal
                        |--------------------------------------------------------------------------
                        */

                        subtotal.textContent = money(data.total);


                        /*
                        |--------------------------------------------------------------------------
                        | Update grand total
                        |--------------------------------------------------------------------------
                        */

                        grandTotal.textContent = money(data.total);


                        /*
                        |--------------------------------------------------------------------------
                        | Update cart item count
                        |--------------------------------------------------------------------------
                        */

                        itemCount.textContent =
                            `${data.item_count} ${data.item_count === 1 ? 'Item' : 'Items'}`;


                        /*
                        |--------------------------------------------------------------------------
                        | Update header cart count
                        |--------------------------------------------------------------------------
                        */

                        document.querySelectorAll('.js-cart-count').forEach((badge) => {
                            badge.textContent = data.item_count;
                        });

                    } catch (error) {

                        console.error(error);

                        window.alert(
                            'Unable to update your cart. Please try again.'
                        );

                    } finally {

                        button.disabled = false;

                    }

                });

            });

        })();
    </script>

@endsection


@endsection
