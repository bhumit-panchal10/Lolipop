@extends('layouts.front')
@section('title', 'Checkout')
@section('content')

    <!-- =====================================================
                                         CHECKOUT PAGE
                                    ====================================================== -->
    <main class="lcheckout-page">
        <section class="lcheckout-section">
            <div class="container">
                <!-- =================================================
                                                     CHECKOUT TOP
                                                ================================================== -->
                <div class="lcheckout-top">
                    <div>
                        <span class="lcheckout-kicker">
                            ALMOST THERE
                        </span>
                        <h2>
                            Complete Your
                            <em>Order</em>
                        </h2>
                        <p>
                            Add your delivery details and choose a payment method.
                        </p>
                    </div>
                    <a href="{{ route('cart.list') }}" class="lcheckout-back">
                        <i class="fa fa-long-arrow-left"></i>
                        Back To Cart
                    </a>
                </div>
                <!-- =================================================
                                                     MAIN LAYOUT
                                                ================================================== -->
                <form action="{{ route('checkoutstore') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div class="lcheckout-layout">
                        <!-- =========================================
                                                         LEFT
                                                    ========================================== -->
                        <div class="lcheckout-left">
                            <!-- =====================================
                                                             CONTACT DETAILS
                                                        ====================================== -->
                            <div class="lcheckout-card">
                                <div class="lcheckout-card-head">
                                    <span class="lcheckout-card-icon pink">
                                        <i class="fa fa-user-o"></i>
                                    </span>
                                    <div>
                                        <small>YOUR DETAILS</small>
                                        <h3>Contact Information</h3>
                                    </div>
                                </div>
                                <div class="lcheckout-form-grid">
                                    <div class="lcheckout-field">
                                        <label>
                                            Mobile Number
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-phone"></i>
                                            <input type="tel" name="billPhone" id="checkoutMobile" maxlength="10"
                                                value="{{ old('billPhone') }}" placeholder="Enter mobile number">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field">
                                        <label>
                                            Full Name
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-user-o"></i>
                                            <input type="text" name="billFirstName" id="checkoutName"
                                                value="{{ old('billFirstName') }}" placeholder="First name">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field">
                                        <label>
                                            Last Name
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-user-o"></i>
                                            <input type="text" name="billLastName" value="{{ old('billLastName') }}"
                                                placeholder="Last name">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field">
                                        <label>
                                            Email Address
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-envelope-o"></i>
                                            <input type="email" name="billEmail" id="checkoutEmail"
                                                value="{{ old('billEmail') }}" placeholder="Enter email address">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                </div>
                            </div>
                            <!-- =====================================
                                                             DELIVERY ADDRESS
                                                        ====================================== -->
                            <div class="lcheckout-card">
                                <div class="lcheckout-card-head">
                                    <span class="lcheckout-card-icon blue">
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                    <div>
                                        <small>DELIVER TO</small>
                                        <h3>Delivery Address</h3>
                                    </div>
                                </div>
                                <div class="lcheckout-form-grid-add">
                                    <div class="lcheckout-field ">
                                        <label>
                                            Address
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-home"></i>
                                            <input type="text" name="billStreetAddress1" id="checkoutAddress"
                                                value="{{ old('billStreetAddress1') }}"
                                                placeholder="House no., building, street">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field ">
                                        <label>
                                            Apartment / Landmark
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-building-o"></i>
                                            <input type="text" name="billStreetAddress2" id="checkoutLandmark"
                                                value="{{ old('billStreetAddress2') }}"
                                                placeholder="Apartment, landmark (optional)">
                                        </div>
                                    </div>
                                </div>
                                <div class="lcheckout-form-grid">
                                    <div class="lcheckout-field ">
                                        <label>
                                            City
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-map"></i>
                                            <input type="text" name="shipping_city" id="checkoutCity"
                                                value="{{ old('shipping_city') }}" placeholder="City">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field">
                                        <label>
                                            State
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-map-o"></i>
                                            <select name="billState" id="checkoutState">
                                                <option value="">
                                                    Select state
                                                </option>
                                                @foreach ($State as $state)
                                                    <option value="{{ $state->stateName }}" @selected(old('billState') === $state->stateName)>
                                                        {{ $state->stateName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i class="fa fa-angle-down lcheckout-select-icon"></i>
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field">
                                        <label>
                                            Pincode
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-map-pin"></i>
                                            <input type="text" name="billPinCode" id="checkoutPincode" maxlength="6"
                                                value="{{ old('billPinCode') }}" placeholder="6-digit pincode">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                    <div class="lcheckout-field">
                                        <label>
                                            Country
                                            <span>*</span>
                                        </label>
                                        <div class="lcheckout-input">
                                            <i class="fa fa-globe"></i>
                                            <input type="text" name="strCountry"
                                                value="{{ old('strCountry', 'India') }}" placeholder="Country">
                                        </div>
                                        <small class="lcheckout-error"></small>
                                    </div>
                                </div>
                            </div>
                            <!-- =====================================
                                                             PAYMENT
                                                        ====================================== -->
                            <!-- <div class="lcheckout-card">
                                                            <div class="lcheckout-card-head">
                                                                <span class="lcheckout-card-icon green">
                                                                    <i class="fa fa-credit-card"></i>
                                                                </span>
                                                                <div>
                                                                    <small>PAY SECURELY</small>
                                                                    <h3>Payment Method</h3>
                                                                </div>
                                                            </div>
                                                            <div class="lcheckout-payment-list">
                                                                <label class="lcheckout-payment active">
                                                                    <input
                                                                        type="radio"
                                                                        name="payment"
                                                                        value="upi"
                                                                        checked
                                                                    >
                                                                    <span class="lcheckout-payment-radio"></span>
                                                                    <span class="lcheckout-payment-icon">
                                                                        <i class="fa fa-mobile"></i>
                                                                    </span>
                                                                    <span class="lcheckout-payment-copy">
                                                                        <strong>
                                                                            Online Payment
                                                                        </strong>
                                                                        <small>
                                                                            Google Pay, PhonePe, Paytm & more
                                                                        </small>
                                                                    </span>
                                                                </label>
                                                                <label class="lcheckout-payment">
                                                                    <input
                                                                        type="radio"
                                                                        name="payment"
                                                                        value="cod"
                                                                    >
                                                                    <span class="lcheckout-payment-radio"></span>
                                                                    <span class="lcheckout-payment-icon">
                                                                        <i class="fa fa-money"></i>
                                                                    </span>
                                                                    <span class="lcheckout-payment-copy">
                                                                        <strong>
                                                                            Cash On Delivery
                                                                        </strong>
                                                                        <small>
                                                                            Pay when your order arrives
                                                                        </small>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div> -->
                        </div>
                        <!-- =========================================
                                                         RIGHT ORDER SUMMARY
                                                    ========================================== -->
                        <aside class="lcheckout-summary">
                            <div class="lcheckout-summary-head">
                                <span>
                                    <i class="fa fa-shopping-bag"></i>
                                </span>
                                <div>
                                    <small>YOUR ORDER</small>
                                    <h3>Order Summary</h3>
                                </div>
                            </div>
                            <!-- PRODUCTS -->
                            <div class="lcheckout-products">
                                @foreach ($cartItems as $item)
                                    <div class="lcheckout-product">
                                        <div class="lcheckout-product-image">
                                            <img src="{{ asset('/Product/Thumbnail/' . ($item->attributes->image ?? '')) }}"
                                                alt="{{ $item->name }}">
                                            <span>{{ $item->quantity }}</span>
                                        </div>
                                        <div class="lcheckout-product-copy">
                                            <small>
                                                {{ $item->categoryname ?? '' }}
                                            </small>
                                            <strong>
                                                {{ $item->name }}
                                            </strong>
                                            <p>
                                                Size:
                                                {{ $item->size_label ?? (optional(\App\Models\ProductAttributes::find($item->size))->product_attribute_size ?? $item->size) }}
                                            </p>
                                        </div>
                                        <strong class="lcheckout-product-price">
                                            ₹{{ number_format($item->price * $item->quantity, 0) }}
                                        </strong>
                                    </div>
                                @endforeach
                            </div>
                            <!-- PRICE -->
                            <div class="lcheckout-price-list">
                                <div>
                                    <span>Subtotal</span>
                                    <strong>₹{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 0) }}</strong>
                                </div>
                                <div>
                                    <span>Product Discount</span>
                                    <strong class="green">
                                        - ₹0
                                    </strong>
                                </div>
                                <div>
                                    <span>Shipping</span>
                                    <strong class="green">
                                        FREE
                                    </strong>
                                </div>
                            </div>
                            <!-- TOTAL -->
                            <div class="lcheckout-total">
                                <div>
                                    <span>
                                        Total Amount
                                    </span>
                                    <strong>
                                        ₹{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 0) }}
                                    </strong>
                                </div>
                            </div>
                            <!-- SAVING -->
                            <div class="lcheckout-saving">
                                <i class="fa fa-smile-o"></i>
                                <span>
                                    You saved
                                    <strong>₹0</strong>
                                    on this order
                                </span>
                            </div>
                            <!-- PLACE ORDER -->
                            <button type="submit" class="lcheckout-place-order" id="checkoutPlaceOrder">
                                <span>
                                    <i class="fa fa-lock"></i>
                                </span>
                                <strong>
                                    Place Order
                                </strong>
                                <i class="fa fa-long-arrow-right"></i>
                            </button>
                        </aside>
                    </div>
                </form>
            </div>
        </section>
    </main>




@endsection

@section('scripts')
    <script>
        (() => {
            const mobile = document.getElementById('checkoutMobile');
            if (!mobile) return;

            const fields = {
                firstName: document.getElementById('checkoutName'),
                lastName: document.querySelector('[name="billLastName"]'),
                email: document.getElementById('checkoutEmail'),
                address1: document.getElementById('checkoutAddress'),
                address2: document.getElementById('checkoutLandmark'),
                city: document.getElementById('checkoutCity'),
                state: document.getElementById('checkoutState'),
                pincode: document.getElementById('checkoutPincode'),
                country: document.querySelector('[name="strCountry"]')
            };
            let lastLookup = '';

            const lookupCustomer = async () => {
                const number = mobile.value.replace(/\D/g, '').slice(0, 10);
                mobile.value = number;
                if (number.length !== 10 || number === lastLookup) return;

                lastLookup = number;
                try {
                    const response = await fetch(
                        `{{ route('checkout.customer') }}?mobile=${encodeURIComponent(number)}`, {
                            headers: {
                                Accept: 'application/json'
                            }
                        }
                    );
                    const result = await response.json();

                    if (result.found) {
                        Object.entries(result.data).forEach(([field, value]) => {
                            if (fields[field] && value !== null && value !== '') {
                                fields[field].value = value;
                            }
                        });
                    }
                } catch (error) {
                    console.error('Customer lookup failed.', error);
                }
            };

            mobile.addEventListener('input', lookupCustomer);
            mobile.addEventListener('change', lookupCustomer);
            mobile.addEventListener('blur', lookupCustomer);
        })();
    </script>
@endsection
