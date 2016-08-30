//jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $("#sub-menu > ul").slideUp(500);
    } else {
        $("#sub-menu > ul").slideDown(500);
    }
});