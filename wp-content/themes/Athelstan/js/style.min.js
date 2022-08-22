jQuery(document).ready(function($) {

    $(".section-8-trademark-list").owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
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

    // $('#backToTop').on('click', function() {
    //     $("body,html").animate({ scrollTop: 0 }, "slow");
    // });

    if ($(window).width() < 992) {
        $('#open-menu').click(function() {
            $(this).css('display', 'none');
            $('#close-menu').css('display', 'block')
            $('#header-main .menu-active').addClass('active');
            $('.af-close-side').addClass('active');
        });
        $('#close-menu').click(function() {
            $(this).css('display', 'none')
            $('#open-menu').css('display', 'block')
            $('#header-main .menu-active').removeClass('active');
            $('.af-close-side').removeClass('active');
        });

        $('#header-main .menu-active #menu-menu-main >.menu-item-has-children>a').click(function(e) {
            e.preventDefault();
            var parent = $(this).parent('li').attr('id');
            if ($('#' + parent).hasClass("active")) {
                $('#' + parent).removeClass('active');
            } else {
                $('#' + parent).addClass('active');
            }
            $('#' + parent).children("ul").slideToggle();
        });
    };

    $('.af-close-side').click(function() {
        $(this).removeClass('active');
        $('#close-menu').css('display', 'none')
        $('.open-menu').css('display', 'block');
        $('#header-main .menu-active').removeClass('active');
        $('#sidebar.widget_news').css('left', '-100%');
    });

    if ($(window).width() > 992) {
        const postDetails = $(".ScrollMagic");
        const postSidebar = $(".widget_scroll");
        if (postDetails.length == 1 && postSidebar.length == 1) {
            const postOT = postDetails['0'].offsetTop;
            const controller = new ScrollMagic.Controller();
            const scene = new ScrollMagic.Scene({
                offset: postOT,
                triggerHook: 0,
                duration: getDuration
            }).addTo(controller);
            scene.setPin(postSidebar['0'], { pushFollowers: false });
        }

        function getDuration() {
            return postDetails['0'].offsetHeight - postSidebar['0'].offsetHeight;
        }
    }
    //Sidebar news
    $('.news-show-sidebar').click(function() {
        $('#sidebar.widget_news').css('left', '0');
        $('.af-close-side').addClass('active');

    });
    $('.list-items-news-close').click(function() {
        $('#sidebar.widget_news').css('left', '-100%');
        $('.af-close-side').removeClass('active');
    });
    $('.af-close-side').click(function() {
        $(this).removeClass('active');
        $('#close-menu').css('display', 'none')
        $('.open-menu').css('display', 'block');
        $('#header-main .bg-main').removeClass('active');
        $('#sidebar.widget_news').css('left', '-100%');
    });

    $("img.lazy").Lazy();
    $("img.wp-post-image").Lazy();

    // $(window).scroll(function() {
    //     if ($(this).scrollTop() > 10) {
    //         $("#header-main").addClass('active');
    //     } else {
    //         $("#header-main").removeClass('active');
    //     }
    // });

    $('.advice-question__content--list--item--link').on('click', function(e) {
        e.preventDefault();
        const id = $(this).attr('href');
        if ($(this).hasClass('active')) {
            $(this).find('h4').removeClass('active');
            $(this).removeClass('active');
            $(id).slideUp();
        } else {
            $('.advice-question__content--list--item--link').removeClass('active');
            $('.advice-question__content--list--item--link h4').removeClass('active');
            $('.advice-question__content--list--item .text').slideUp();
            $(id).slideDown();
            $(this).find('h4').addClass('active');
            $(this).addClass('active');
        }
    });
    $('.section-7-item-right-number-assess-wrap').each(function(e, index) {
        const width = $(this).find('.statistic-number').width();
        $(this).find('.statistic-number').css('width', width)
    })
    var animate = document.getElementById("statistic");
    if (animate) {
        jQuery(window).scroll(startCounter);

        function startCounter() {
            var hT = jQuery('#statistic').offset().top,
                hH = jQuery('#statistic').outerHeight(),
                wH = jQuery(window).height();
            if (jQuery(window).scrollTop() > hT + hH - wH) {
                jQuery(window).off("scroll", startCounter);
                jQuery('.statistic-number').each(function() {
                    var $this = jQuery(this);
                    jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(new Intl.NumberFormat().format(Math.ceil(this.Counter)) + '');
                        }
                    });
                });
            }
        }
    }

    autoPlayYouTubeModal();

    function autoPlayYouTubeModal() {
        var trigger = $('.btn-video-wrap .btn-video');
        trigger.click(function() {
            $("#video-modal").addClass('active');
            var theModal = $(this).data("target");
            var videoSRC = $(this).attr("data-videoModal");
            var videoSRCauto = videoSRC + "?autoplay=1";
            $(theModal + ' iframe').attr('src', videoSRCauto);
            $(theModal).on('#video-modal', function(e) {
                $(theModal + ' iframe').attr('src', '');
            });
        });
        $('#video-modal').on('click', function() {
            $("#video-modal").removeClass('active');
            $('#video-modal iframe').attr('src', '');
        });
    };
});

var wow = new WOW({
    boxClass: 'wow', // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset: 0, // distance to the element when triggering the animation (default is 0)
    mobile: true, // trigger animations on mobile devices (default is true)
    live: true, // act on asynchronously loaded content (default is true)
    callback: function(box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
    },
    scrollContainer: null, // optional scroll container selector, otherwise use window,
    resetAnimation: true, // reset animation on end (default is true)
});
wow.init();