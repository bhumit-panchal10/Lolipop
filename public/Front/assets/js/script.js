document.addEventListener("DOMContentLoaded", () => {
    /* =====================================================
       SEARCH PANEL
    ===================================================== */
    const searchTrigger = document.querySelector(".search-trigger");
    const searchPanel = document.getElementById("searchPanel");
    const searchClose = document.getElementById("searchClose");
    if (searchTrigger && searchPanel) {
        searchTrigger.addEventListener("click", () => {
            searchPanel.classList.toggle("open");
        });
    }
    if (searchClose && searchPanel) {
        searchClose.addEventListener("click", () => {
            searchPanel.classList.remove("open");
        });
    }
    /* =====================================================
       MOBILE MENU
    ===================================================== */
    const mobileToggle = document.getElementById("mobileToggle");
    const mobileMenu = document.getElementById("mobileMenu");
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener("click", (event) => {
            event.stopPropagation();
            mobileMenu.classList.toggle("open");
        });
        /* =====================================================
           MOBILE ACCORDION
        ===================================================== */
        const mobileParents = document.querySelectorAll(".mobile-parent");
        mobileParents.forEach((button) => {
            button.addEventListener("click", () => {
                const currentGroup = button.closest(".mobile-group");
                document.querySelectorAll(".mobile-group").forEach((group) => {
                    if (group !== currentGroup) {
                        group.classList.remove("open");
                    }
                });
                if (currentGroup) {
                    currentGroup.classList.toggle("open");
                }
            });
        });
        /* =====================================================
           CLOSE MOBILE MENU AFTER LINK CLICK
        ===================================================== */
        const mobileLinks = document.querySelectorAll(
            ".mobile-link, .mobile-sub a"
        );
        mobileLinks.forEach((link) => {
            link.addEventListener("click", () => {
                mobileMenu.classList.remove("open");
            });
        });
        /* =====================================================
           CLOSE MOBILE MENU ON OUTSIDE CLICK
        ===================================================== */
        document.addEventListener("click", (event) => {
            if (
                window.innerWidth <= 1080 &&
                !event.target.closest("#mobileMenu") &&
                !event.target.closest("#mobileToggle")
            ) {
                mobileMenu.classList.remove("open");
            }
        });
        /* =====================================================
           RESET MOBILE MENU ON DESKTOP
        ===================================================== */
        window.addEventListener("resize", () => {
            if (window.innerWidth > 1080) {
                mobileMenu.classList.remove("open");
                document
                    .querySelectorAll(".mobile-group")
                    .forEach((group) => {
                        group.classList.remove("open");
                    });
            }
        });
    }
    /* =====================================================
       SWIPER HERO SLIDER
    ===================================================== */
    const heroSliderElement = document.querySelector(".heroSwiper");
    if (
        heroSliderElement &&
        typeof Swiper !== "undefined"
    ) {
        const currentSlide =
            document.querySelector(".hero-current-slide");
        const totalSlides =
            document.querySelector(".hero-total-slides");
        const heroSwiper = new Swiper(".heroSwiper", {
            /* -----------------------------------------
               BASIC
            ----------------------------------------- */
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            speed: 900,
            /* -----------------------------------------
               EFFECT
            ----------------------------------------- */
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            /* -----------------------------------------
               AUTOPLAY
            ----------------------------------------- */
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            /* -----------------------------------------
               PAGINATION
            ----------------------------------------- */
            pagination: {
                el: ".hero-swiper-pagination",
                clickable: true
            },
            /* -----------------------------------------
               PREVIOUS / NEXT
            ----------------------------------------- */
            navigation: {
                nextEl: ".hero-swiper-next",
                prevEl: ".hero-swiper-prev"
            },
            /* -----------------------------------------
               KEYBOARD
            ----------------------------------------- */
            keyboard: {
                enabled: true
            },
            /* -----------------------------------------
               ACCESSIBILITY
            ----------------------------------------- */
            a11y: {
                enabled: true,
                prevSlideMessage: "Previous banner",
                nextSlideMessage: "Next banner",
                firstSlideMessage: "This is the first banner",
                lastSlideMessage: "This is the last banner"
            },
            /* -----------------------------------------
               EVENTS
            ----------------------------------------- */
            on: {
                init(swiper) {
                    updateSlideCounter(swiper);
                },
                slideChange(swiper) {
                    updateSlideCounter(swiper);
                }
            }
        });
        /* =====================================================
           UPDATE 01 / 03 SLIDE COUNTER
        ===================================================== */
        function updateSlideCounter(swiper) {
            const total = swiper.slides.length;
            const active = swiper.realIndex + 1;
            if (currentSlide) {
                currentSlide.textContent =
                    String(active).padStart(2, "0");
            }
            if (totalSlides) {
                totalSlides.textContent =
                    String(total).padStart(2, "0");
            }
        }
    }
    /* =====================================================
     SHOP BY CATEGORY
  ===================================================== */

    // const categoryTabs =
    //     document.querySelectorAll(".category-tab");
    // const categoryPanels =
    //     document.querySelectorAll(".category-panel");
    // /* Store Swiper instances */
    // const categorySwipers = [];
    // /* =====================================================
    //    INITIALIZE EACH CATEGORY SWIPER
    // ===================================================== */
    // categoryPanels.forEach((panel) => {
    //     const swiperElement =
    //         panel.querySelector(".subcategory-swiper");
    //     const nextButton =
    //         panel.querySelector(".category-next");
    //     const prevButton =
    //         panel.querySelector(".category-prev");
    //     if (!swiperElement) {
    //         return;
    //     }
    //     const swiper = new Swiper(swiperElement, {
    //         slidesPerView: 1.3,
    //         spaceBetween: 14,
    //         speed: 650,
    //         grabCursor: true,
    //         watchOverflow: true,
    //         observer: true,
    //         observeParents: true,
    //         navigation: {
    //             nextEl: nextButton,
    //             prevEl: prevButton
    //         },
    //         breakpoints: {
    //             480: {
    //                 slidesPerView: 2.1,
    //                 spaceBetween: 14
    //             },
    //             700: {
    //                 slidesPerView: 3.1,
    //                 spaceBetween: 16
    //             },
    //             950: {
    //                 slidesPerView: 4.2,
    //                 spaceBetween: 17
    //             },
    //             1200: {
    //                 slidesPerView: 5.2,
    //                 spaceBetween: 18
    //             },
    //             1450: {
    //                 slidesPerView: 6,
    //                 spaceBetween: 18
    //             }
    //         }
    //     });
    //     categorySwipers.push({
    //         panel: panel,
    //         swiper: swiper
    //     });
    // });
    /* =====================================================
       CATEGORY TAB CLICK
    ===================================================== */
    categoryTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            const selectedCategory =
                tab.dataset.category;
            /* Remove active from tabs */
            categoryTabs.forEach((item) => {
                item.classList.remove("active");
            });
            /* Add active tab */
            tab.classList.add("active");
            /* Hide all panels */
            categoryPanels.forEach((panel) => {
                panel.classList.remove("active");
            });
            /* Show selected panel */
            const selectedPanel =
                document.querySelector(
                    `.category-panel[data-panel="${selectedCategory}"]`
                );
            if (selectedPanel) {
                selectedPanel.classList.add("active");
                /* Update Swiper after panel becomes visible */
                const selectedSwiper =
                    categorySwipers.find(
                        (item) => item.panel === selectedPanel
                    );
                if (selectedSwiper) {
                    setTimeout(() => {
                        selectedSwiper.swiper.update();
                        selectedSwiper.swiper.slideTo(0);
                    }, 50);
                }
            }
        });
    });
});
/* ============================================
   TESTIMONIAL SLIDER
============================================ */
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".lc-testimonial-slider");
    const track = document.querySelector(".lc-testimonial-track");
    const cards = document.querySelectorAll(".lc-testimonial-card");
    const prevBtn = document.querySelector(".lc-prev");
    const nextBtn = document.querySelector(".lc-next");
    const currentNumber = document.querySelector(".lc-current-slide");
    const totalNumber = document.querySelector(".lc-total-slide");
    const progressBar = document.querySelector(
        ".lc-progress-line span"
    );
    let currentSlide = 0;
    const totalSlides = cards.length;
    let autoSlide;
    /* ---------------------------
       Total Number
    --------------------------- */
    totalNumber.textContent =
        String(totalSlides).padStart(2, "0");
    /* ---------------------------
       Update Slider
    --------------------------- */
    function updateSlider() {
        if (!cards.length) return;
        const cardWidth =
            cards[0].offsetWidth;
        const gap =
            parseFloat(
                getComputedStyle(track).gap
            ) || 0;
        const move =
            (cardWidth + gap) * currentSlide;
        track.style.transform =
            `translateX(-${move}px)`;
        currentNumber.textContent =
            String(currentSlide + 1)
                .padStart(2, "0");
        const progress =
            ((currentSlide + 1) / totalSlides) * 100;
        progressBar.style.width =
            `${progress}%`;
    }
    /* ---------------------------
       Next
    --------------------------- */
    function nextSlide() {
        currentSlide++;
        if (currentSlide >= totalSlides) {
            currentSlide = 0;
        }
        updateSlider();
    }
    /* ---------------------------
       Previous
    --------------------------- */
    function prevSlide() {
        currentSlide--;
        if (currentSlide < 0) {
            currentSlide =
                totalSlides - 1;
        }
        updateSlider();
    }
    /* ---------------------------
       Buttons
    --------------------------- */
    nextBtn.addEventListener(
        "click",
        function () {
            nextSlide();
            restartAutoSlide();
        }
    );
    prevBtn.addEventListener(
        "click",
        function () {
            prevSlide();
            restartAutoSlide();
        }
    );
    /* ---------------------------
       Auto Slide
    --------------------------- */
    function startAutoSlide() {
        autoSlide =
            setInterval(
                nextSlide,
                4800
            );
    }
    function restartAutoSlide() {
        clearInterval(autoSlide);
        startAutoSlide();
    }
    /* ---------------------------
       Pause on Hover
    --------------------------- */
    slider.addEventListener(
        "mouseenter",
        function () {
            clearInterval(autoSlide);
        }
    );
    slider.addEventListener(
        "mouseleave",
        function () {
            startAutoSlide();
        }
    );
    /* ---------------------------
       Swipe Support
    --------------------------- */
    let startX = 0;
    let endX = 0;
    slider.addEventListener(
        "touchstart",
        function (event) {
            startX =
                event.touches[0].clientX;
        },
        { passive: true }
    );
    slider.addEventListener(
        "touchend",
        function (event) {
            endX =
                event.changedTouches[0].clientX;
            const difference =
                startX - endX;
            if (Math.abs(difference) > 50) {
                if (difference > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
                restartAutoSlide();
            }
        },
        { passive: true }
    );
    /* ---------------------------
       Resize
    --------------------------- */
    window.addEventListener(
        "resize",
        updateSlider
    );
    /* Initial */
    updateSlider();
    startAutoSlide();
});
/* =====================================================
   CHECKOUT PAGE
===================================================== */
document.addEventListener("DOMContentLoaded", function () {
    const checkoutPage =
        document.querySelector(".lcheckout-page");
    if (!checkoutPage) {
        return;
    }
    /* =================================================
       ADDRESS TYPE
    ================================================= */
    document
        .querySelectorAll(
            ".lcheckout-address-type button"
        )
        .forEach(function (button) {
            button.addEventListener(
                "click",
                function () {
                    document
                        .querySelectorAll(
                            ".lcheckout-address-type button"
                        )
                        .forEach(function (item) {
                            item.classList.remove(
                                "active"
                            );
                        });
                    this.classList.add(
                        "active"
                    );
                }
            );
        });
    /* =================================================
       PAYMENT METHOD
    ================================================= */
    document
        .querySelectorAll(
            ".lcheckout-payment"
        )
        .forEach(function (payment) {
            payment.addEventListener(
                "click",
                function () {
                    document
                        .querySelectorAll(
                            ".lcheckout-payment"
                        )
                        .forEach(function (item) {
                            item.classList.remove(
                                "active"
                            );
                        });
                    this.classList.add(
                        "active"
                    );
                    const radio =
                        this.querySelector(
                            'input[type="radio"]'
                        );
                    radio.checked = true;
                }
            );
        });
    /* =================================================
       FIELD ERROR
    ================================================= */
    function setError(
        input,
        message
    ) {
        const field =
            input.closest(
                ".lcheckout-field"
            );
        const error =
            field.querySelector(
                ".lcheckout-error"
            );
        if (error) {
            error.textContent =
                message;
        }
        input
            .closest(
                ".lcheckout-input"
            )
            .style.borderColor =
            message
                ? "#dc5264"
                : "";
    }
    /* =================================================
       VALIDATION
    ================================================= */
    document
        .getElementById(
            "checkoutPlaceOrder"
        )
        .addEventListener(
            "click",
            function () {
                const name =
                    document.getElementById(
                        "checkoutName"
                    );
                const mobile =
                    document.getElementById(
                        "checkoutMobile"
                    );
                const email =
                    document.getElementById(
                        "checkoutEmail"
                    );
                const address =
                    document.getElementById(
                        "checkoutAddress"
                    );
                const city =
                    document.getElementById(
                        "checkoutCity"
                    );
                const state =
                    document.getElementById(
                        "checkoutState"
                    );
                const pincode =
                    document.getElementById(
                        "checkoutPincode"
                    );
                let valid = true;
                /* NAME */
                if (
                    name.value.trim().length < 2
                ) {
                    setError(
                        name,
                        "Please enter your full name."
                    );
                    valid = false;
                }
                else {
                    setError(
                        name,
                        ""
                    );
                }
                /* MOBILE */
                if (
                    !/^[0-9]{10}$/.test(
                        mobile.value.trim()
                    )
                ) {
                    setError(
                        mobile,
                        "Enter a valid 10-digit mobile number."
                    );
                    valid = false;
                }
                else {
                    setError(
                        mobile,
                        ""
                    );
                }
                /* EMAIL */
                const emailPattern =
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (
                    !emailPattern.test(
                        email.value.trim()
                    )
                ) {
                    setError(
                        email,
                        "Enter a valid email address."
                    );
                    valid = false;
                }
                else {
                    setError(
                        email,
                        ""
                    );
                }
                /* ADDRESS */
                if (
                    address.value.trim().length < 5
                ) {
                    setError(
                        address,
                        "Please enter your delivery address."
                    );
                    valid = false;
                }
                else {
                    setError(
                        address,
                        ""
                    );
                }
                /* CITY */
                if (
                    city.value.trim() === ""
                ) {
                    setError(
                        city,
                        "Please enter city."
                    );
                    valid = false;
                }
                else {
                    setError(
                        city,
                        ""
                    );
                }
                /* STATE */
                if (
                    state.value === ""
                ) {
                    setError(
                        state,
                        "Please select state."
                    );
                    valid = false;
                }
                else {
                    setError(
                        state,
                        ""
                    );
                }
                /* PINCODE */
                if (
                    !/^[0-9]{6}$/.test(
                        pincode.value.trim()
                    )
                ) {
                    setError(
                        pincode,
                        "Enter a valid 6-digit pincode."
                    );
                    valid = false;
                }
                else {
                    setError(
                        pincode,
                        ""
                    );
                }
                /* SUCCESS */
                if (!valid) {
                    const firstError =
                        document.querySelector(
                            ".lcheckout-error:not(:empty)"
                        );
                    firstError
                        ?.closest(
                            ".lcheckout-field"
                        )
                        ?.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    return;
                }
                /*
                  Backend/payment integration later.
                  For static design currently:
                */
                window.location.href =
                    "order-success.html";
            }
        );
});
/* =====================================================
   MY ORDERS PAGE
===================================================== */
document.addEventListener("DOMContentLoaded", function () {
    const orderPage =
        document.querySelector(".lord-page");
    if (!orderPage) {
        return;
    }
    const tabs =
        document.querySelectorAll(
            ".lord-tabs button"
        );
    const cards =
        [
            ...document.querySelectorAll(
                ".lord-card"
            )
        ];
    const search =
        document.getElementById(
            "lordSearch"
        );
    const empty =
        document.getElementById(
            "lordEmpty"
        );
    let activeStatus =
        "all";
    /* =================================================
       FILTER ORDERS
    ================================================= */
    function filterOrders() {
        const searchValue =
            search.value
                .trim()
                .toLowerCase();
        let visible =
            0;
        cards.forEach(function (card) {
            const status =
                card.dataset.status;
            const order =
                card.dataset.order
                    .toLowerCase();
            const productText =
                card.textContent
                    .toLowerCase();
            const statusMatch =
                activeStatus === "all" ||
                status === activeStatus;
            const searchMatch =
                !searchValue ||
                order.includes(searchValue) ||
                productText.includes(searchValue);
            if (
                statusMatch &&
                searchMatch
            ) {
                card.classList.remove(
                    "hide"
                );
                visible++;
            }
            else {
                card.classList.add(
                    "hide"
                );
            }
        });
        empty.classList.toggle(
            "show",
            visible === 0
        );
    }
    /* =================================================
       TAB CLICK
    ================================================= */
    tabs.forEach(function (button) {
        button.addEventListener(
            "click",
            function () {
                tabs.forEach(function (item) {
                    item.classList.remove(
                        "active"
                    );
                });
                this.classList.add(
                    "active"
                );
                activeStatus =
                    this.dataset.orderFilter;
                filterOrders();
            }
        );
    });
    /* =================================================
       SEARCH
    ================================================= */
    search.addEventListener(
        "input",
        filterOrders
    );
});
/* =====================================================
   PRODUCT DETAIL ACCORDION / DROPDOWN
===================================================== */
document.addEventListener("DOMContentLoaded", function () {
    const accordions =
        document.querySelectorAll(".pdx-accordion");
    if (!accordions.length) {
        return;
    }
    accordions.forEach(function (accordion) {
        const button =
            accordion.querySelector(".pdx-accordion-head");
        const body =
            accordion.querySelector(".pdx-accordion-body");
        const toggleIcon =
            button.querySelector(":scope > i:last-child");
        /* INITIAL STATE */
        if (accordion.classList.contains("active")) {
            body.style.display = "block";
            if (toggleIcon) {
                toggleIcon.className = "fa fa-minus";
            }
        }
        else {
            body.style.display = "none";
            if (toggleIcon) {
                toggleIcon.className = "fa fa-plus";
            }
        }
        /* CLICK */
        button.addEventListener("click", function () {
            const isOpen =
                accordion.classList.contains("active");
            /* CLOSE ALL */
            accordions.forEach(function (item) {
                const itemBody =
                    item.querySelector(".pdx-accordion-body");
                const itemIcon =
                    item.querySelector(
                        ".pdx-accordion-head > i:last-child"
                    );
                item.classList.remove("active");
                itemBody.style.display = "none";
                if (itemIcon) {
                    itemIcon.className = "fa fa-plus";
                }
            });
            /* OPEN CLICKED ITEM */
            if (!isOpen) {
                accordion.classList.add("active");
                body.style.display = "block";
                if (toggleIcon) {
                    toggleIcon.className = "fa fa-minus";
                }
            }
        });
    });
});
