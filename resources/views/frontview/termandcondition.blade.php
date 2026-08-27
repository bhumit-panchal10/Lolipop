@extends('layouts.front')
@section('title', 'Terms & Conditions')
@section('content')

    <!-- Start Contact -->
    {{-- <section class="blog-single section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {!! $datas->description !!}
                </div>
            </div>
        </div>
    </section> --}}
    <main class="terms-page">
        <section class="terms-section">
            <div class="container">
                <!-- =================================================
                     PAGE INTRO
                ================================================== -->
                <div class="terms-intro">
                    <div class="terms-intro-copy">
                        <span class="terms-kicker">
                            SHOP WITH CONFIDENCE
                        </span>
                        <h2>
                            Terms &
                            <em>Condition</em>
                        </h2>
                        <!-- <p>
                            These Terms & Conditions explain the rules that
                            apply when you browse, shop or place an order
                            through the Lolipop Children Wear website.
                        </p> -->
                    </div>
                </div>

                <!-- =================================================
                     MAIN LAYOUT
                ================================================== -->
                <div class="terms-layout">

                    <div class="terms-content">
                        <!-- =========================================
                             01 INTRODUCTION
                        ========================================== -->
                        <article class="terms-card" id="termsIntroduction">
                            <div class="terms-card-title">
                                <span class="terms-card-number pink">
                                    01
                                </span>
                                <div>
                                    <small>
                                        WELCOME TO LOLIPOP
                                    </small>
                                    <h3>
                                        Introduction
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Welcome to Lolipop Children Wear. These
                                    Terms & Conditions govern your use of our
                                    website and any purchase made through it.
                                </p>
                                <p>
                                    When you browse our website, create an
                                    account, add products to your wishlist or
                                    cart, or place an order, you agree to follow
                                    these terms.
                                </p>
                                <p>
                                    If you do not agree with any part of these
                                    terms, please do not use the website or place
                                    an order.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             02 WEBSITE USE
                        ========================================== -->
                        <article class="terms-card" id="termsEligibility">
                            <div class="terms-card-title">
                                <span class="terms-card-number blue">
                                    02
                                </span>
                                <div>
                                    <small>
                                        USING OUR WEBSITE
                                    </small>
                                    <h3>
                                        Eligibility & Website Use
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    You may use this website for personal and
                                    lawful shopping purposes only.
                                </p>
                                <ul>
                                    <li>
                                        Information provided while ordering
                                        should be accurate and complete.
                                    </li>
                                    <li>
                                        You are responsible for keeping your
                                        account information secure.
                                    </li>
                                    <li>
                                        You must not misuse the website,
                                        interfere with its operation or attempt
                                        unauthorised access.
                                    </li>
                                    <li>
                                        Orders should only be placed using valid
                                        contact and payment information.
                                    </li>
                                </ul>
                            </div>
                        </article>
                        <!-- =========================================
                             03 PRODUCTS
                        ========================================== -->
                        <article class="terms-card" id="termsProducts">
                            <div class="terms-card-title">
                                <span class="terms-card-number green">
                                    03
                                </span>
                                <div>
                                    <small>
                                        LITTLE DETAILS MATTER
                                    </small>
                                    <h3>
                                        Products, Colours & Sizes
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    We try to display every product, colour,
                                    pattern, fabric description and size as
                                    accurately as possible.
                                </p>
                                <p>
                                    Actual colours may vary slightly depending
                                    on your screen, lighting conditions or
                                    photography.
                                </p>
                                <div class="terms-highlight green">
                                    <span>
                                        <i class="fa fa-arrows-h"></i>
                                    </span>
                                    <p>
                                        Children’s clothing sizes can vary by
                                        design and fit. Please check the available
                                        size information before completing your
                                        purchase.
                                    </p>
                                </div>
                                <p>
                                    Product availability is subject to stock.
                                    Adding an item to your cart or wishlist does
                                    not guarantee that the item will remain
                                    available.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             04 ORDERS
                        ========================================== -->
                        <article class="terms-card" id="termsOrders">
                            <div class="terms-card-title">
                                <span class="terms-card-number orange">
                                    04
                                </span>
                                <div>
                                    <small>
                                        PLACING YOUR ORDER
                                    </small>
                                    <h3>
                                        Orders & Confirmation
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    After placing an order, you may receive an
                                    order acknowledgement or confirmation through
                                    the contact details provided during checkout.
                                </p>
                                <p>
                                    An order may be cancelled or declined if:
                                </p>
                                <ul>
                                    <li>
                                        The selected product is no longer
                                        available.
                                    </li>
                                    <li>
                                        Payment cannot be verified or completed.
                                    </li>
                                    <li>
                                        Incorrect pricing or product information
                                        was displayed because of a technical or
                                        human error.
                                    </li>
                                    <li>
                                        Delivery is not available to the supplied
                                        location.
                                    </li>
                                    <li>
                                        We reasonably suspect fraudulent or
                                        unauthorised activity.
                                    </li>
                                </ul>
                                <p>
                                    If payment has already been collected for an
                                    order we cannot fulfil, the applicable amount
                                    will be refunded according to the payment
                                    provider's processing timeline.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             05 PRICING
                        ========================================== -->
                        <article class="terms-card" id="termsPricing">
                            <div class="terms-card-title">
                                <span class="terms-card-number pink">
                                    05
                                </span>
                                <div>
                                    <small>
                                        SAFE & SIMPLE CHECKOUT
                                    </small>
                                    <h3>
                                        Pricing & Payment
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Product prices displayed on the website are
                                    shown in Indian Rupees unless otherwise
                                    stated.
                                </p>
                                <p>
                                    Prices, discounts and promotional offers may
                                    change without prior notice.
                                </p>
                                <p>
                                    The final amount payable will be shown during
                                    checkout before you place your order.
                                    Applicable delivery charges, discounts or
                                    other charges will also be displayed where
                                    relevant.
                                </p>
                                <div class="terms-highlight blue">
                                    <span>
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <p>
                                        Payments may be processed through
                                        authorised third-party payment service
                                        providers. We do not guarantee the
                                        availability of every payment method at
                                        all times.
                                    </p>
                                </div>
                            </div>
                        </article>
                        <!-- =========================================
                             06 SHIPPING
                        ========================================== -->
                        <article class="terms-card" id="termsShipping">
                            <div class="terms-card-title">
                                <span class="terms-card-number blue">
                                    06
                                </span>
                                <div>
                                    <small>
                                        FROM OUR STORE TO YOUR DOOR
                                    </small>
                                    <h3>
                                        Shipping & Delivery
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Delivery times shown on the website are
                                    estimates and may vary depending on location,
                                    courier availability, holidays, weather or
                                    circumstances beyond our reasonable control.
                                </p>
                                <p>
                                    Please provide a complete delivery address,
                                    correct pincode and reachable mobile number.
                                </p>
                                <p>
                                    We are not responsible for delays caused by
                                    incorrect delivery information provided by
                                    the customer.
                                </p>
                                <div class="terms-mini-grid">
                                    <div>
                                        <span class="blue">
                                            <i class="fa fa-truck"></i>
                                        </span>
                                        <strong>
                                            Delivery
                                        </strong>
                                        <p>
                                            Estimated timelines may differ by
                                            location.
                                        </p>
                                    </div>
                                    <div>
                                        <span class="green">
                                            <i class="fa fa-map-marker"></i>
                                        </span>
                                        <strong>
                                            Address
                                        </strong>
                                        <p>
                                            Please provide accurate delivery
                                            details.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!-- =========================================
                             07 RETURNS
                        ========================================== -->
                        <article class="terms-card" id="termsReturns">
                            <div class="terms-card-title">
                                <span class="terms-card-number green">
                                    07
                                </span>
                                <div>
                                    <small>
                                        SHOP WITH PEACE OF MIND
                                    </small>
                                    <h3>
                                        Returns & Exchanges
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Eligible products may be returned or exchanged
                                    according to the return and exchange policy
                                    displayed on our website.
                                </p>
                                <p>
                                    Unless otherwise stated for a particular item,
                                    products should normally be returned:
                                </p>
                                <ul>
                                    <li>
                                        Unused, unworn and unwashed.
                                    </li>
                                    <li>
                                        With original tags and packaging.
                                    </li>
                                    <li>
                                        Without stains, damage, alterations or
                                        signs of use.
                                    </li>
                                    <li>
                                        Together with any accessories supplied
                                        with the product.
                                    </li>
                                </ul>
                                <div class="terms-highlight orange">
                                    <span>
                                        <i class="fa fa-refresh"></i>
                                    </span>
                                    <p>
                                        Products marked final sale,
                                        non-returnable or subject to special
                                        hygiene restrictions may not qualify for
                                        return or exchange.
                                    </p>
                                </div>
                            </div>
                        </article>
                        <!-- =========================================
                             08 CANCELLATION
                        ========================================== -->
                        <article class="terms-card" id="termsCancellation">
                            <div class="terms-card-title">
                                <span class="terms-card-number orange">
                                    08
                                </span>
                                <div>
                                    <small>
                                        CHANGED YOUR MIND?
                                    </small>
                                    <h3>
                                        Order Cancellation
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Orders may be cancelled only while cancellation
                                    is available for that order.
                                </p>
                                <p>
                                    Once an order has been packed, shipped or
                                    handed to a courier partner, cancellation
                                    may no longer be possible.
                                </p>
                                <p>
                                    If a successfully paid order is cancelled
                                    before dispatch, any applicable refund will
                                    be processed to the original payment method.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             09 COUPONS
                        ========================================== -->
                        <article class="terms-card" id="termsOffers">
                            <div class="terms-card-title">
                                <span class="terms-card-number pink">
                                    09
                                </span>
                                <div>
                                    <small>
                                        HAPPY LITTLE SAVINGS
                                    </small>
                                    <h3>
                                        Offers, Discounts & Coupons
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Coupons and promotional offers may have
                                    specific eligibility conditions, expiry
                                    dates, minimum purchase requirements and
                                    product exclusions.
                                </p>
                                <p>
                                    Unless specifically stated, multiple offers
                                    may not be combined in a single order.
                                </p>
                                <p>
                                    We reserve the right to modify, suspend or
                                    withdraw a promotional offer where reasonably
                                    necessary.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             10 INTELLECTUAL PROPERTY
                        ========================================== -->
                        <article class="terms-card" id="termsIntellectual">
                            <div class="terms-card-title">
                                <span class="terms-card-number blue">
                                    10
                                </span>
                                <div>
                                    <small>
                                        OUR CREATIVE WORLD
                                    </small>
                                    <h3>
                                        Intellectual Property
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Website designs, logos, product photographs,
                                    graphics, illustrations, text and other
                                    content displayed on this website may be
                                    protected by intellectual property rights.
                                </p>
                                <p>
                                    You may not reproduce, copy, republish,
                                    distribute or commercially use website
                                    content without appropriate permission.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             11 LIABILITY
                        ========================================== -->
                        <article class="terms-card" id="termsLiability">
                            <div class="terms-card-title">
                                <span class="terms-card-number orange">
                                    11
                                </span>
                                <div>
                                    <small>
                                        IMPORTANT INFORMATION
                                    </small>
                                    <h3>
                                        Limitation of Liability
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    We make reasonable efforts to keep website
                                    information accurate and services available.
                                    However, the website may occasionally be
                                    unavailable or contain errors because of
                                    maintenance, technical issues or circumstances
                                    outside our control.
                                </p>
                                <p>
                                    To the extent permitted by applicable law,
                                    Lolipop Children Wear will not be responsible
                                    for indirect, incidental or consequential
                                    losses resulting from use of the website.
                                </p>
                                <p>
                                    Nothing in these Terms & Conditions excludes
                                    any consumer rights that cannot legally be
                                    excluded.
                                </p>
                            </div>
                        </article>
                        <!-- =========================================
                             12 PRIVACY
                        ========================================== -->
                        <article class="terms-card" id="termsPrivacy">
                            <div class="terms-card-title">
                                <span class="terms-card-number green">
                                    12
                                </span>
                                <div>
                                    <small>
                                        YOUR INFORMATION MATTERS
                                    </small>
                                    <h3>
                                        Privacy
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    Personal information submitted while using
                                    our website is handled according to our
                                    Privacy Policy.
                                </p>
                                <p>
                                    This may include information necessary to
                                    process orders, arrange delivery, provide
                                    customer support and operate website
                                    functionality.
                                </p>
                                <a href="privacy-policy.html" class="terms-inline-link">
                                    Read Privacy Policy
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                        <!-- =========================================
                             13 CHANGES
                        ========================================== -->
                        <article class="terms-card" id="termsChanges">
                            <div class="terms-card-title">
                                <span class="terms-card-number blue">
                                    13
                                </span>
                                <div>
                                    <small>
                                        KEEPING THINGS CURRENT
                                    </small>
                                    <h3>
                                        Changes To These Terms
                                    </h3>
                                </div>
                            </div>
                            <div class="terms-card-body">
                                <p>
                                    We may update these Terms & Conditions when
                                    our website, services, policies or legal
                                    requirements change.
                                </p>
                                <p>
                                    The updated version will be published on this
                                    page together with a revised update date.
                                </p>
                                <p>
                                    Continued use of the website after updated
                                    terms are published means the updated terms
                                    will apply to future use of the website.
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
