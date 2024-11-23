/* ============ Main JS ============ */

(function ($) {
    "use strict";
    
        //Toggle Js
		$('.rr-checkout-login-form-reveal-btn').on('click', function () {
			$('#rrReturnCustomerLoginForm').slideToggle(400);
		});

        $('.rr-checkout-coupon-form-reveal-btn').on('click', function () {
			$('#rrCheckoutCouponForm').slideToggle(400);
		});


    /*======================================
        Preloader activation
    ========================================*/
    $(window).on("load", function (event) {
        $("#preloader").delay(1000).fadeOut(500);
        // Text Animation
        setTimeout(() => {
        var hasAnim = $(".anim-text");
            hasAnim.each(function () {
                var $this = $(this);
                var splitto = new SplitType($this, {
                types: "lines, chars",
                className: "char",
                });
                var chars = $this.find(".char");
                gsap.fromTo(
                chars,
                { y: "100%" },
                {
                    y: "0%",
                    duration: 0.9,
                    stagger: 0.03,
                    ease: "power2.out",
                }
                );
            });
        }, 1000);
    });

    $(".preloader-close").on("click", function () {
        $("#preloader").delay(0).fadeOut(500);
    });

    $(document).ready(function () {


        if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
            $('body').addClass('firefox');
        }
        
        var header = $(".header"),
            stickyHeader = $(".primary-header");

        function menuSticky(w) {
            if (w.matches) {
                
                $(window).on("scroll", function () {
                    var scroll = $(window).scrollTop();
                    if (scroll >= 110) {
                        stickyHeader.addClass("fixed");
                    } else {
                        stickyHeader.removeClass("fixed");
                    }
                });
                if ($(".header").length > 0) {    
                    var  headerHeight = document.querySelector(".header"),
                        setHeaderHeight = headerHeight.offsetHeight;	
                    header.each(function () {
                        $(this).css({
                            'height' : setHeaderHeight + 'px'
                        });
                    });
                }
            }
        }

        var minWidth = window.matchMedia("(min-width: 992px)");
        if (header.hasClass("sticky-active")) {
            menuSticky(minWidth);
        }

        // //Mobile Menu Js
        // $(".mobile-menu-items").meanmenu({
        //     meanMenuContainer: ".side-menu-wrap",
        //     meanScreenWidth: "992",
        //     meanMenuCloseSize: "30px",
        //     meanRemoveAttrs: true,
        //     meanExpand: ['<i class="fa-solid fa-caret-down"></i>'],
        // });

        // // Mobile Sidemenu
        // $(".mobile-side-menu-toggle").on("click", function () {
        //     $(".mobile-side-menu, .mobile-side-menu-overlay").toggleClass("is-open");
        // });

        // $(".mobile-side-menu-close, .mobile-side-menu-overlay").on("click", function () {
        //     $(".mobile-side-menu, .mobile-side-menu-overlay").removeClass("is-open");
        // });

        // Popup Search Box
        $(function () {
            $("#popup-search-box").removeClass("toggled");

            $(".dl-search-icon").on("click", function (e) {
                e.stopPropagation();
                $("#popup-search-box").toggleClass("toggled");
                $("#popup-search").focus();
            });

            $("#popup-search-box input").on("click", function (e) {
                e.stopPropagation();
            });

            $("#popup-search-box, body").on("click", function () {
                $("#popup-search-box").removeClass("toggled");
            });
        });

        // Popup Sidebox
        function sideBox() {
            $("body").removeClass("open-sidebar");
            $(document).on("click", ".sidebar-trigger", function (e) {
                e.preventDefault();
                $("body").toggleClass("open-sidebar");
            });
            $(document).on("click", ".sidebar-trigger.close, #sidebar-overlay", function (e) {
                e.preventDefault();
                $("body.open-sidebar").removeClass("open-sidebar");
            });
        }

        sideBox();

       

        // Data Background
        $("[data-background").each(function () {
            $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
        });

        // Custom Cursor
        $("body").append('<div class="mt-cursor"></div>');
        var cursor = $(".mt-cursor"),
            linksCursor = $("a, .swiper-nav, button, .cursor-effect"),
            crossCursor = $(".cross-cursor");

        $(window).on("mousemove", function (e) {
            cursor.css({
                transform: "translate(" + (e.clientX - 15) + "px," + (e.clientY - 15) + "px)",
                visibility: "inherit",
            });
        });

        /* Odometer */
        $(".odometer").waypoint(
            function () {
                var odo = $(".odometer");
                odo.each(function () {
                    var countNumber = $(this).attr("data-count");
                    $(this).html(countNumber);
                });
            },
            {
                offset: "80%",
                triggerOnce: true,
            }
        );

        // Nice Select Js
        $("select").niceSelect();

        // Isotop
        $(".filter-items").imagesLoaded(function () {
            // Add isotope click function
            $(".project-filter li").on("click", function () {
                // $(".project-filter li").removeClass("active");
                
                $(".project-filter li").removeClass("btn-info btn-outline-secondary text-white");
                $(".project-filter li").not(this).addClass("btn-outline-secondary");
                // $(this).addClass("active");
                $(this).addClass("btn-info  text-white");

                var selector = $(this).attr("data-filter");
                $(".filter-items").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: "linear",
                        queue: false,
                    },
                });
                return false;
            });

            $(".filter-items").isotope({
                itemSelector: ".single-item",
                layoutMode: "fitRows",
                fitRows: {
                    gutter: 0,
                },
            });
        });

        //Category Carousel
        const swiperNew = new Swiper('.category-carousel', {
            // Optional parameters
            loop: false,
            centeredSlides: false,
            // Navigation arrows
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
            breakpoints: {
              // when window width is >= 320px
              768: {
                slidesPerView: 2,
                spaceBetween: 10
              },
              // when window width is >= 480px
              1024: {
                slidesPerView: 3,
                spaceBetween: 20
              },
              // when window width is >= 640px
              1200: {
                slidesPerView: 4,
                spaceBetween: 20
              }
            }
          });


    

        var swiperTrending = new Swiper(".trending-carousel", {
            slidesPerView: 6,
            spaceBetween: 10,
            slidesPerGroup: 1,
            loop: false,
            speed: 700,
            autoplay: false,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
              },
                // freeMode: true,
                // mousewheel: {
                // releaseOnEdges: true,
                // },
                scrollbar: {
                    el: ".swiper-scrollbar",
                    hide: false,
                  },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView:2,
                    slidesPerGroup: 1,
                    spaceBetween: 20,
                },
                // when window width is >= 767px
                767: {
                    slidesPerView: 3,
                    slidesPerGroup: 1,
                    spaceBetween: 20,
                },
                // when window width is >= 1024px
                992: {
                    slidesPerView: 4,
                    slidesPerGroup: 1,
                    spaceBetween: 20,
                },
                // when window width is >= 1024px
                1170: {
                    slidesPerView: 6,
                    slidesPerGroup: 1,
                    spaceBetween: 30,
                },
            },
        });


        //Testimonial Carousel
        var swiperTesti = new Swiper(".testimonial-carousel", {
            slidesPerView: 3,
            spaceBetween: 10,
            slidesPerGroup: 1,
            loop: true,
            speed: 700,
            autoplay: false,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".testimonial-section .swiper-prev",
                prevEl: ".testimonial-section .swiper-next",
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    spaceBetween: 20,
                },
                // when window width is >= 767px
                767: {
                    slidesPerView: 2,
                    slidesPerGroup: 1,
                    spaceBetween: 30,
                },
                // when window width is >= 1024px
                992: {
                    slidesPerView: 3,
                    slidesPerGroup: 1,
                    spaceBetween: 30,
                },
            },
        });

        //Swiper Slider For Shop
        var swiper = new Swiper(".product-gallary-thumb", {
            spaceBetween: 10,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
            direction: 'vertical',
        });
        
        var swiper2 = new Swiper(".product-gallary", {
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: ".swiper-nav-next",
                prevEl: ".swiper-nav-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });

        //Running Animated Text
        const scrollers = document.querySelectorAll(".scroller");

        if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
            addAnimation();
        }

        function addAnimation() {
            scrollers.forEach((scroller) => {
                scroller.setAttribute("data-animated", true);

                const scrollerInner = scroller.querySelector(".scroller__inner");
                const scrollerContent = Array.from(scrollerInner.children);

                scrollerContent.forEach((item) => {
                    const duplicatedItem = item.cloneNode(true);
                    duplicatedItem.setAttribute("aria-hidden", true);
                    scrollerInner.appendChild(duplicatedItem);
                });
            });
        }

        // Price range slider
        var priceRange = $("#price-range"),
            priceOutput = $("#price-output span");
            priceOutput.html(priceRange.val());
            priceRange.on("change input", function () {
            priceOutput.html($(this).val());
        });

        // Page Scroll Percentage
        function scrollTopPercentage() {
            const scrollPercentage = () => {
                const scrollTopPos = document.documentElement.scrollTop;
                const calcHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrollValue = Math.round((scrollTopPos / calcHeight) * 100);
                const scrollElementWrap = $("#scroll-percentage");

                scrollElementWrap.css("background", `conic-gradient( var(--rr-color-theme-primary) ${scrollValue}%, var(--rr-color-common-white) ${scrollValue}%)`);
                
                // ScrollProgress
                if ( scrollTopPos > 100 ) {
                    scrollElementWrap.addClass("active");
                } else {
                    scrollElementWrap.removeClass("active");
                }

                if( scrollValue < 96 ) {
                    $("#scroll-percentage-value").text(`${scrollValue}%`);
                } else {
                    $("#scroll-percentage-value").html('<i class="fa-solid fa-arrow-up"></i>');
                }
            }
            window.onscroll = scrollPercentage;
            window.onload = scrollPercentage;

            // Back to Top
            function scrollToTop() {
                document.documentElement.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }
            
            $("#scroll-percentage").on("click", scrollToTop);
        }

        scrollTopPercentage();

    });
})(jQuery);

const fetchFreshCsrfToken = () => {
    $.ajax({
        url: baseUrl+'csrf_token',
        type: 'GET',
        success: function(data) {
            $('#_tt_cc').val(data.token);
            $('#_cc').val(data.token);
        }
    })
}

/**
 * Used by search and categories page for filtering products
 * @param {*} key 
 * @param {*} value 
 * @param {*} isChecked 
 */
const makeUrl = (key, value, isChecked) => {
    const searchParams = new URLSearchParams(window.location.search);

    // Check if the key exists in the query parameters
    if (searchParams.has(key)) {
        let currentValue = searchParams.get(key);
        let values = currentValue.split('|'); // Split the parameter values by '|'

        if (isChecked) {
            // Add the value if not already present
            if (!values.includes(value.toString())) {
                values.push(value.toString());
            }
        } else {
            // Remove the value if it exists (for unchecked case)
            values = values.filter(val => val !== value.toString());
        }

        // Update the query parameter
        if (values.length > 0) {
            searchParams.set(key, values.join('|')); // Join values back with '|'
        } else {
            searchParams.delete(key); // Remove the key if no values are left
        }
    } else {
        // If the key doesn't exist and the checkbox is checked, add it
        if (isChecked) {
            searchParams.set(key, value);
        }
    }

    // Recreate the URL with updated query parameters
    let newUrl = `${current_url.split('?')[0]}?${searchParams.toString()}`;

    // Decode the URL for readability
    let decodedUrl = decodeURIComponent(newUrl);

    // Optionally navigate to the new URL
    window.location.href = decodedUrl;
};
