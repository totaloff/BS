/*
-------------------------------------------
  STICKY NAVIGATION
-------------------------------------------
*/
jQuery(function($) {

    "use strict";

    var STICKY_APPEARS = 129;
    var TOP_SPACING = 0;
    var IS_SLIDER = false;

    jQuery(document).ready(function () {

        var nav_container = $("#nav-container"),
            nav = nav_container.find("nav"),
            wpAdminBar = $('#wpadminbar'),
            slider = $(".rev_slider");

        if (nav_container.hasClass("phoenix-transparent-top-menu") &&
            typeof slider.length != 'undefined' &&
            slider.length != 0 &&
            slider.position().top == 0) {

            IS_SLIDER = true;

            wpAdminBar = (typeof wpAdminBar.length != 'undefined') ? wpAdminBar.height() : false;

            if (wpAdminBar) {
                nav_container.css({"position": "relative", "z-index": "999", "top": wpAdminBar});
            } else {
                nav_container.css({"position": "relative", "z-index": "999"});
            }
            nav.css({"position": "fixed", "background": "transparent"});

            STICKY_APPEARS = slider.outerHeight() + 50;
        }

    });

    jQuery(document).scroll(function () {

        setTimeout(function() {
            var y = $(document).scrollTop(),
                wpAdminBar = $('#wpadminbar'),
                nav_container = $("#nav-container"),
                nav = nav_container.find("nav"),
                top_spacing = TOP_SPACING,
                offset = 0;

            wpAdminBar = (typeof wpAdminBar.length != 'undefined') ? wpAdminBar.height() : 0;
            top_spacing = top_spacing + wpAdminBar;

            if (y >= STICKY_APPEARS) {
                if (!nav.hasClass("sticky")) {
                    nav_container.css({ 'height' : nav.outerHeight() });
                    nav.stop().addClass("sticky").css("top", -nav.outerHeight()).animate({"top" : top_spacing}, 0);
                }
            } else {
                nav_container.css({ 'height':'auto' });
                if (IS_SLIDER) {

                    var topPos;

                    if (wpAdminBar) {
                        topPos = nav.parent().css("top");
                    } else {
                        topPos = 0;
                    }

                    nav.stop().removeClass("sticky").css("top",nav.outerHeight() + offset).animate({"top" : topPos}, 0);
                } else {
                    nav.stop().removeClass("sticky").css("top",nav.outerHeight() + offset).animate({"top" : ""}, 0);
                }
            }
        }, 10);
    });

});
