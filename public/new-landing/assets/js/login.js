$("#login-tab").on("click", function () {
  $("#login-tab").addClass("active");
  $("#signup-tab").removeClass("active");
  $("#nav-login").addClass("active");
  $("#nav-signup").removeClass("active");
});

$("#signup-tab").on("click", function () {
  $("#signup-tab").addClass("active");
  $("#login-tab").removeClass("active");
  $("#nav-login").removeClass("active");
  $("#nav-signup").addClass("active");
});

(function ($) {
  "use strict";

  //slider main

  //slider main
  //Swiper Slider For Shop
  var swiperMain = new Swiper(".sliderMain", {
    slidesPerView: 1,
    spaceBetween: 0,

    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    // watchSlidesProgress: true,
    //  direction: 'horizantal',
    navigation: {
      nextEl: ".swiper-nav-next",
      prevEl: ".swiper-nav-prev",
    },
  });
})(jQuery);

$('.newLandingAccountModel').click(function() {
  let id = $(this).attr('data-id');
  $(id).click();
})
