( function ($) {

    "use strict";

    $(document).ready(function() {

    // Header Background Advanced Box {
        var adv          =  $('#primary_page_header_advanced'),
            bgField      =  $('#primary_page_header_bg'),
            dividerLast  =  $('.rwmb-divider-wrapper:last'),
            dividerFirst =  $('.rwmb-divider-wrapper:first'),
            wrapperObj      =  $('<div />', {
                "id": "primary-page-header-advanced-section"
            });

            dividerFirst.nextUntil(dividerLast).andSelf().wrapAll(wrapperObj);

            var wrapperEl = $('#primary-page-header-advanced-section');

            if (adv.is(':checked')) {
                wrapperEl.slideDown();
            } else {
                wrapperEl.slideUp();
            }

            adv.on('click', function () {
                if ($(this).is(':checked')) {
                    wrapperEl.slideDown();
                } else {
                    wrapperEl.slideUp();
                }
            });
    // }

    // Portfolio Page Categoriy        
        var template = $('#page_template'),
            templateVal = template.val(),
            catSelect = $('#primary_page_portfolio_cat');

        if (templateVal === 'template-portfolio.php') {
        } else {
            catSelect.parent().parent().hide();
        }

        template.on('change', function () {
            if ($(this).val() === 'template-portfolio.php') {
                catSelect.parent().parent().slideDown();
            } else {
                catSelect.parent().parent().slideUp();
            }
        });


    // Layout && Widgets Area Relations
        var layoutObj = {
            layoutSwitch: $('[name = primary_page_layout]').parent(),

            layoutCurrent: $('[name = primary_page_layout]:checked'),

            layout: null,

            widgetsArea: $('#primary_page_widgets_area').parent().parent(),

            setLayout: function () {
                return this.layoutCurrent.val();
            }
        };

        layoutObj.layout = layoutObj.setLayout();

        if (layoutObj.layout === 'no') {
            layoutObj.widgetsArea.hide();
        }

        layoutObj.layoutSwitch.on('click', function() {
            layoutObj.layout = $(this).find('input').val();
            if (layoutObj.layout === 'no') {
                layoutObj.widgetsArea.slideUp();
            } else {
                layoutObj.widgetsArea.slideDown();
            }
        });

    });

} )(jQuery);
