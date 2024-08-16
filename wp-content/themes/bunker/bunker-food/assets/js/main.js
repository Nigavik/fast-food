
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

    },
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

});

$('.sort').on('click', function () {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active')
    } else {
        $(this).addClass('active')
    }
})

$('.sort ul li button').on('click', function () {
    $('.sort ul li button').removeClass('active')
    $(this).addClass('active')
    $(this).parent().parent().parent().children().eq(0).text($(this).text())

})
$('.product-popap-box .dop-nav button').on('click', function () {
    $('.product-popap-box .dop-nav button').removeClass('active')
    $(this).addClass('active');
    console.log($(this).index())
    console.log($(this).position())
    left = $(this).position()['left']

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
})
$('.catalog-nav>.catalog-nav-subcat button.filter-close ').on('click', function () {
    $('.catalog-nav>.catalog-nav-subcat button ').removeClass('active')

})