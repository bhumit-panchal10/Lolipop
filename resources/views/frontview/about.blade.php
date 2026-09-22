@extends('layouts.front')
@section('title', 'About Us')
@section('content')
    <!-- =====================================================
                         ABOUT PAGE
                    ====================================================== -->
    <main class="labout-page">
        <!-- =================================================
                             STORY SECTION
                        ================================================== -->
        <section class="labout-story">
            <div class="container">
                <div class="labout-story-grid">
                    <!-- =========================================
                                         LEFT VISUAL
                                    ========================================== -->
                    <div class="labout-visual">
                        <div class="labout-main-photo">
                            <img src="{{ asset('/Front/assets/images/about-store.jpg') }}" alt="Lolipop Children Wear">
                        </div>
                        <div class="labout-small-photo">
                            <img src="{{ asset('/Front/assets/images/about-kidswear.jpg') }}" alt="Kidswear collection">
                        </div>
                        <div class="labout-floating-card">
                            <span>
                                <i class="fa fa-heart"></i>
                            </span>
                            <div>
                                <small>
                                    MADE WITH LOVE
                                </small>
                                <strong>
                                    For little personalities
                                </strong>
                            </div>
                        </div>
                        <span class="labout-dot dot-pink"></span>
                        <span class="labout-dot dot-blue"></span>
                        <span class="labout-dot dot-green"></span>
                    </div>
                    <!-- =========================================
                                         RIGHT CONTENT
                                    ========================================== -->
                    <div class="labout-story-content">
                        <span class="labout-kicker">
                            ABOUT US
                        </span>
                        <h2>
                            Lollipop
                            <em>Childrenwear</em>
                        </h2>
                        <p class="labout-lead">
                            Lollipop Childrenwear was launched in 2012. So, we have vast experience about children's clothing.
                        </p>
                        <p>
                            Lollipop Childrenwear was created with a passion for fashion and commitment to quality. We understand that
                            children's clothing needs to be comfortable, durable and stylish - without compromise.
                        </p>
                        <p>
                            Our purchasing team carefully studies global fashion, trends and caters them into practical, kid-friendly designs.
                            Every garment is crafted with attention to detail, ensuring a perfect fit, vibrant colors and superior comfort.
                        </p>
                        <div class="labout-signature">
                            <span class="labout-sign-icon">
                                <i class="fa fa-star"></i>
                            </span>
                            <div>
                                <strong>
                                    Wear happy. Grow colourful.
                                </strong>
                                <small>
                                    THE LOLIPOP WAY
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                             BRAND IDEA
                        ================================================== -->
        <section class="labout-purpose">
            <div class="container">
                <div class="labout-purpose-shell">
                    <div class="labout-purpose-head">
                        <span>
                            WHY LOLIPOP?
                        </span>
                        <h2>
                            Childhood isn't one colour.
                            <em>Neither are we.</em>
                        </h2>
                        <p>
                            Every child has their own personality, mood and
                            way of exploring the world. Our collections are
                            designed to celebrate that individuality.
                        </p>
                    </div>
                    <div class="labout-purpose-grid">
                        <!-- 01 -->
                        <article class="labout-purpose-card pink">

                            <div class="labout-purpose-icon">
                                <i class="fa fa-heart-o"></i>
                            </div>
                            <h3>
                                Happy To Wear
                            </h3>
                            <p>
                                Clothing should feel as good as it looks,
                                with comfortable styles made for active days.
                            </p>
                        </article>
                        <!-- 02 -->
                        <article class="labout-purpose-card blue">

                            <div class="labout-purpose-icon">
                                <i class="fa fa-smile-o"></i>
                            </div>
                            <h3>
                                Made For Childhood
                            </h3>
                            <p>
                                Easy silhouettes and playful looks made for
                                school, outings, parties and everything between.
                            </p>
                        </article>
                        <!-- 03 -->
                        <article class="labout-purpose-card green">

                            <div class="labout-purpose-icon">
                                <i class="fa fa-leaf"></i>
                            </div>
                            <h3>
                                Thoughtful Comfort
                            </h3>
                            <p>
                                We focus on wearable designs that help little
                                ones move, play and enjoy their day freely.
                            </p>
                        </article>
                        <!-- 04 -->
                        <article class="labout-purpose-card orange">

                            <div class="labout-purpose-icon">
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h3>
                                Everyday Special
                            </h3>
                            <p>
                                Because ordinary days deserve cheerful outfits
                                just as much as celebrations do.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                             OUR JOURNEY
                        ================================================== -->
        <section class="labout-journey">
            <div class="container">
                <div class="labout-section-head">
                    <div>
                        <span class="labout-kicker">
                            OUR JOURNEY
                        </span>
                        <h2>
                            Growing with
                            <em>every little smile.</em>
                        </h2>
                    </div>
                    <p>
                        Our journey is built around one simple idea —
                        making children's fashion joyful, comfortable
                        and easy to shop.
                    </p>
                </div>
                <div class="labout-timeline">
                    <!-- STEP 01 -->
                    <div class="labout-time-item">
                        <div class="labout-time-year pink">
                            <span>01</span>
                        </div>
                        <div class="labout-time-card">
                            <small>
                                THE IDEA
                            </small>
                            <h3>
                                A colourful beginning
                            </h3>
                            <p>
                                Lolipop started with a simple vision:
                                create a happy destination for children's
                                everyday fashion.
                            </p>
                        </div>
                    </div>
                    <!-- STEP 02 -->
                    <div class="labout-time-item">
                        <div class="labout-time-year blue">
                            <span>02</span>
                        </div>
                        <div class="labout-time-card">
                            <small>
                                THE COLLECTION
                            </small>
                            <h3>
                                Styles for every little personality
                            </h3>
                            <p>
                                Girls, boys and baby collections came together
                                with playful colours, easy fits and cheerful
                                everyday styles.
                            </p>
                        </div>
                    </div>
                    <!-- STEP 03 -->
                    <div class="labout-time-item">
                        <div class="labout-time-year green">
                            <span>03</span>
                        </div>
                        <div class="labout-time-card">
                            <small>
                                THE EXPERIENCE
                            </small>
                            <h3>
                                Making shopping easier
                            </h3>
                            <p>
                                We continue improving the way families
                                discover, choose and shop children's clothing.
                            </p>
                        </div>
                    </div>
                    <!-- STEP 04 -->
                    <div class="labout-time-item">
                        <div class="labout-time-year orange">
                            <span>04</span>
                        </div>
                        <div class="labout-time-card">
                            <small>
                                TODAY & BEYOND
                            </small>
                            <h3>
                                More little adventures ahead
                            </h3>
                            <p>
                                Our story keeps growing with every collection,
                                every family and every colourful childhood moment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                             SPECIAL SECTION
                        ================================================== -->
        <section class="labout-special">
            <div class="container">
                <div class="labout-special-grid">
                    <!-- LEFT -->
                    <div class="labout-special-copy">
                        <span class="labout-kicker">
                            WHAT MAKES US DIFFERENT
                        </span>
                        <h2>
                            Thought for kids.
                            <em>Loved by families.</em>
                        </h2>
                        <p>
                            Every detail of the Lolipop experience is designed
                            to keep shopping simple, cheerful and dependable.
                        </p>
                        <div class="labout-feature-list">
                            <div class="labout-feature">
                                <span class="blue">
                                    <i class="fa fa-arrows"></i>
                                </span>
                                <div>
                                    <strong>
                                        Easy Everyday Fits
                                    </strong>
                                    <p>
                                        Styles designed for movement,
                                        comfort and busy little days.
                                    </p>
                                </div>
                            </div>
                            <div class="labout-feature">
                                <span class="pink">
                                    <i class="fa fa-magic"></i>
                                </span>
                                <div>
                                    <strong>
                                        Playful Design
                                    </strong>
                                    <p>
                                        Colourful looks made to feel fresh,
                                        fun and full of personality.
                                    </p>
                                </div>
                            </div>
                            <div class="labout-feature">
                                <span class="green">
                                    <i class="fa fa-refresh"></i>
                                </span>
                                <div>
                                    <strong>
                                        Easy Shopping
                                    </strong>
                                    <p>
                                        Simple browsing, order tracking and
                                        convenient support when you need it.
                                    </p>
                                </div>
                            </div>
                            <div class="labout-feature">
                                <span class="orange">
                                    <i class="fa fa-comments-o"></i>
                                </span>
                                <div>
                                    <strong>
                                        Friendly Support
                                    </strong>
                                    <p>
                                        Questions about size, products or orders?
                                        We're always happy to help.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT VISUAL -->
                    <div class="labout-special-visual">
                        <div class="labout-special-img">
                            <img src="{{ asset('/Front/assets/images/about-children.jpg') }}"
                                alt="Happy children in Lolipop kidswear">
                        </div>
                        <div class="labout-special-badge">
                            <strong>
                                Made For
                            </strong>
                            <span>
                                Little Adventures
                            </span>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="labout-special-circle circle-one"></div>
                        <div class="labout-special-circle circle-two"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================
                             NUMBERS / TRUST
                        ================================================== -->
        <section class="labout-numbers">
            <div class="container">
                <div class="labout-number-shell">
                    <div class="labout-number-intro">
                        <span>
                            LOLIPOP IN LITTLE NUMBERS
                        </span>
                        <h2>
                            Small details.
                            <em>Big happy moments.</em>
                        </h2>
                    </div>
                    <div class="labout-number-grid">
                        <div class="labout-number-item">
                            <strong>
                                3
                            </strong>
                            <span>
                                Kidswear Worlds
                            </span>
                            <small>
                                Girls • Boys • Baby
                            </small>
                        </div>
                        <div class="labout-number-item">
                            <strong>
                                100%
                            </strong>
                            <span>
                                Happy Style Focus
                            </span>
                            <small>
                                Comfort meets colour
                            </small>
                        </div>
                        <div class="labout-number-item">
                            <strong>
                                7
                            </strong>
                            <span>
                                Day Easy Returns
                            </span>
                            <small>
                                On eligible products
                            </small>
                        </div>
                        <div class="labout-number-item">
                            <strong>
                                ₹999+
                            </strong>
                            <span>
                                Free Shipping
                            </span>
                            <small>
                                On qualifying orders
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
