jQuery(function ($) {

    "use strict";

    $('.'+ PhoenixTeam.THEME_SLUG +'-demo-content').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            text = $this.text(),
            parent = $this.parent().parent(),
            input = parent.find('input');

        input.val(text);
    });

    $('#publish, #save-post').on('click', function (e) {
        var selects = $('#'+ PhoenixTeam.THEME_SLUG +'_team_socials_name_description').parent().find('select.rwmb-select-advanced'),
            urls = $('#'+ PhoenixTeam.THEME_SLUG +'_team_socials_url_description').parent().find('input.rwmb-url'),
            emptyEls = [];

        if (selects.length !== urls.length) {
            alert(PhoenixTeam.teamFieldsMatchErr);
            validationNotMatch();
            window.scrollTo(0,document.body.scrollHeight);
            return false;
        }

        if (selects.length > 1 && urls.length > 1) {
            selects.each(function (i, el) {
                var $this = $(el);
                if (!$this.val()) {
                    emptyEls.push($this);
                }
            });

            urls.each(function (i, el) {
                var $this = $(el);
                if (!$this.val()) {
                    emptyEls.push($this);
                }
            });
        }

        if (emptyEls.length > 0) {
            e.preventDefault();
            alert(PhoenixTeam.teamFieldaFilledErr);

            for (var i = 0; i < emptyEls.length; i++) {
                validationIsEmpty(emptyEls[i]);
            }

            window.scrollTo(0,document.body.scrollHeight);
        }

        function validationIsEmpty (el) {
            var borderColor;

            if (el.context.tagName === "SELECT") {
                el = el.parent().find('.select2-container').find('.select2-choice');
            }

            borderColor = el.css('border-color');
            
            el
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color': borderColor}, 1000)
                .delay(80)
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color': borderColor}, 1000)
                .delay(80)
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color': borderColor}, 1000);

            return false;
        }

        function validationNotMatch () {
            selects.parent().find('.select2-container').find('.select2-choice')
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color':'#AAA'}, 1000)
                .delay(80)
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color':'#AAA'}, 1000)
                .delay(80)
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color':'#AAA'}, 1000);

            urls
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color':'#DDD'}, 1000)
                .delay(80)
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color':'#DDD'}, 1000)
                .delay(80)
                .animate({'border-color' : '#FF0000'}, 0)
                .delay(80)
                .animate({'border-color':'#DDD'}, 1000);

            return false;
        }
    });

});