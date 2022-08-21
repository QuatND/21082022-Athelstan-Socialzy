jQuery(document).ready(function($) {
    $("#myCarouselBackground .carousel-inner").owlCarousel({
        loop: !0,
        margin: 0,
        nav: !0,
        dots: !1,
        items: 1,
        autoplay: !0,
        autoplayTimeout: 3,
        autoplayHoverPause: !0,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    });
    $(".owl-news").owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: false,
        items: 4,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2,
                margin: 15,
            },
            500: {
                items: 3,
                margin: 15,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4
            }
        }
    });
    $(".owl-trademark").owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: false,
        items: 6,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 2,
                margin: 15,
            },
            500: {
                items: 3,
                margin: 15,
            },
            768: {
                items: 4,
            },
            992: {
                items: 6
            }
        }
    });
    // $('#backToTop').on('click', function() {
    //     $("body,html").animate({ scrollTop: 0 }, "slow");
    // });
    $('.page-template-tpl-home  .departments-menu .dropdown-menu-category').css('display', 'block');
    $(".show-dropdown-menu").on("click", function(e) {
        e.preventDefault();
        $(".dropdown-menu-category").slideToggle();
        $(".page-template-tpl-home .electro-navbar-inner .departments-menu .dropdown-menu-category").css("visibility", "visible");
    });
    if ($(window).width() < 992) {
        $('#header-main .departments-menu .dropdown-menu-category').css('display', "none");
        $('#open-menu').click(function() {
            $(this).css('display', 'none');
            $('#close-menu').css('display', 'block')
            $('#header-main .bg-main').addClass('active');
        });
        $('#close-menu').click(function() {
            $(this).css('display', 'none')
            $('#open-menu').css('display', 'block')
            $('#header-main .bg-main').removeClass('active');
        });
    };
});