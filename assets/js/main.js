"use strict"

$(window).on("load", function () {


    $('.btn-tab-next').on('click', function (e) {
        e.preventDefault();
        $('.nav-tabs .nav-item > .active').parent().next('li').find('a').trigger('click');
    });
    $('.custom-file input[type="file"]').on('change', function () {
        var filename = $(this).val().split('\\').pop();
        $(this).next().text(filename);
    });
});