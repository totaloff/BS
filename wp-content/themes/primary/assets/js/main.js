jQuery(function($) {
  "use strict";
  // Twitter
  (function() {
    var twitterBlock = $('.xenia-shortcode-twitter-feed').find('.phoenix-twitter-slider-wrapper');

    if (twitterBlock.length > 0) {
      var ul = twitterBlock.find(".tweet_list");

      ul.cycle({
        fx: 'fade',
        timeout: 5000,
        sync: 0,
        speed: 700
      });

      twitterBlock.find('#prev').click(function() {
        ul.cycle('prev');
      });

      twitterBlock.find('#next').click(function() {
        ul.cycle('next');
      });
    }
  })();
  // Twitter END

  // Popups
  jQuery('.phoenixteam-image-link').magnificPopup({
    type: 'image',
    closeOnContentClick: false,
    closeBtnInside: false,
    mainClass: 'mfp-no-margins mfp-with-zoom',
    gallery: {
      enabled: true
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300
    }
  });
  // Popup
});

// Animation
jQuery(window).scroll(function() {
  jQuery(".animated-area").each(function() {
    if (jQuery(window).height() + jQuery(window).scrollTop() - jQuery(this).offset().top > 0) {
      jQuery(this).trigger("animate-it");
    }
  });
});

jQuery(".animated-area").on("animate-it", function() {
  var cf = $(this);
  cf.find(".animated").each(function() {
    jQuery(this).css("-webkit-animation-duration", "0.9s");
    jQuery(this).css("-moz-animation-duration", "0.9s");
    jQuery(this).css("-ms-animation-duration", "0.9s");
    jQuery(this).css("animation-duration", "0.9s");
    jQuery(this).css("-webkit-animation-delay", jQuery(this).attr("data-animation-delay"));
    jQuery(this).css("-moz-animation-delay", jQuery(this).attr("data-animation-delay"));
    jQuery(this).css("-ms-animation-delay", jQuery(this).attr("data-animation-delay"));
    jQuery(this).css("animation-delay", jQuery(this).attr("data-animation-delay"));
    jQuery(this).addClass(jQuery(this).attr("data-animation"));
  });
});
// Animation
