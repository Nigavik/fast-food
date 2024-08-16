jQuery(document).ready(function ($) {
      setTimeout(function() { 
          

    var swiper = new Swiper(".banner", {

        centeredSlides: true,
        breakpoints: {

            10: {
                slidesPerView: 1.5,
                spaceBetween: 10,
            },
            450: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            600: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            800: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1010: {
                slidesPerView: 3,
                spaceBetween: 30,
            },

        },  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

    });
    }, 2500);
    $('.sort').on('click', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        } else {
            $(this).addClass('active')
        }
    })

    $('.sort ul li button').on('click', function (a, b) {
        $('.sort ul li button').removeClass('active')
        $(this).addClass('active')
        $(this).parent().parent().parent().children().eq(0).text($(this).text())

        $sort = $(this).attr('data-sorting');

        $(this).parent().parent().parent().parent().parent().children().eq(1).children().sort(function (a, b) {
            if ($sort == 2) { return $(a).data("price") - $(b).data("price"); }
            if ($sort == 1) { return $(b).data("price") - $(a).data("price"); }
            if ($sort == 0) { return $(a).data("number") - $(b).data("number"); }
        }).appendTo($(this).parent().parent().parent().parent().parent().children().eq(1));

    })
    $('.product-popap-box .dop-nav button').on('click', function () {
        $('.product-popap-box .dop-nav button').removeClass('active')
        $(this).addClass('active');

        left = $(this).position()['left']
        $('.product-dop-ingredient').removeClass('active')
        if ($(this).index() === 1) {
            $('.product-dop-ingredient.sauce').addClass('active')
        } else {
            $('.product-dop-ingredient.dop').addClass('active')
        }

        $('.product-popap-box .dop-nav .after').css('left', left)


    })
    $('.product-box .select ').on('click', function () {

        $(this).addClass('active')
        $('body').addClass('none-scroll')
    })

    $('.product-box  .overlay ').on('click', function () {

        $(this).parent().parent().children().eq(1).removeClass('active')
        $('body').removeClass('none-scroll')

    })
    $('.product-box  .close ').on('click', function () {
        $('body').removeClass('none-scroll')
        $(this).parent().parent().parent().children().eq(1).removeClass('active')

    })
    $('.catalog-nav>.catalog-nav-subcat button ').on('click', function () {
        $('.catalog-nav>.catalog-nav-subcat button ').removeClass('active')
        $(this).addClass('active')
        $data = $(this).attr('data-id');
        $box = $(this).parent().parent().parent().children().eq(1).children();
        if ($data != 0) {
            $($box).each(function (i) {

            
                if ($(this).data('cat') != $data) {
                    $(this).addClass('none');
                }
                else {
                    $(this).removeClass('none');
                }
            });
        }
        else {
            $($box).removeClass('none');
        }
        /*  $(this).parent().parent().parent().children().eq(1).children().addClass('none')
          $(this).parent().parent().parent().children().eq(1).children().data({cat:$data}).remove('none')*/
  

    })
    $('.catalog-nav>.catalog-nav-subcat button.filter-close ').on('click', function () {
        $('.catalog-nav>.catalog-nav-subcat button ').removeClass('active')

    })


    $('.product-dop-ingredient button').on('click', function () {
        $count = +$(this).parent().children().eq(1).attr('data-count')

        if ($(this).hasClass('plus')) {
            $count = $count + 1;
            $(this).parent().children().eq(1).attr('data-count', $count);
            $(this).parent().parent().attr('data-count', $count);
            $(this).parent().children().eq(1).text('x' + $count)
        } else {
            if ($count < 1) {
                $count = 0;
            } else {
                $count = $count - 1
            }
            $(this).parent().children().eq(1).attr('data-count', $count);
            $(this).parent().parent().attr('data-count', $count);
            $(this).parent().children().eq(1).text('x' + $count)
        }

    })

})