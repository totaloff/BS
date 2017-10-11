jQuery(document).ready(function ($) {
    $('#giveReview').click(function () {

        $.post(ajaxurl, {
            action: 'giveReviewNow',
        }, function (response) {
            jQuery('#showNotice').hide();

        });

    });
    $('#notGood').click(function () {

        $.post(ajaxurl, {
            action: 'giveReviewNow',
        }, function (response) {
            jQuery('.noticeMessage').hide();
            jQuery('.goodEnoughMessage').show();
            jQuery('#showNotice').delay(3000).fadeOut();

        });

    });
    $('#mayBeLater').click(function () {

        $.post(ajaxurl, {
            action: 'giveReviewLater',
        }, function (response) {
            jQuery('.noticeMessage').hide();
            jQuery('.laterMessage').show();
            jQuery('#showNotice').delay(3000).fadeOut();


        });

    });

});

 