jQuery(document).ready(function ($) {
   
    $('.popap.call-me').on('click', function () {

        $('.call-popap').addClass('active')


    })

    $('.call-popap .overlay, .call-popap .close').on('click', function () {

        $('.call-popap').removeClass('active')

    })
    $('#search-form-active').on('click', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            $(this).addClass('close')
        } else {
            $(this).addClass('active')
            $(this).removeClass('close')
        }
    })


    $('.mob-menu .parent>li').on('click', function () {
        $(this).toggleClass('active')

    })


    $('.burger').on('click', function () {
        $(this).toggleClass('active')

    })
})