//metaboxes toggle if a post format is chosen
jQuery.fn.extend({

    showPostFormats: function () {
        "use strict";

        var $this = jQuery(this),
            theSelectedFormat  = $this.attr("id"),
            post_formats = {};

        //post formats / option pairs
        post_formats['post-format-link']    =   "#PhoenixTeam_link_post_custom_fields";
        post_formats['post-format-quote']   =   "#PhoenixTeam_quote_post_custom_fields";
        post_formats['post-format-audio']   =   "#PhoenixTeam_audio_post_custom_fields";
        post_formats['post-format-video']   =   "#PhoenixTeam_video_post_custom_fields";
        post_formats['post-format-gallery'] =   "#PhoenixTeam_gallery_post_custom_fields";
        // post_formats['post-format-0']    =   "#PhoenixTeam_standard_post_custom_fields";

        for (var key in post_formats) {
            jQuery(post_formats[key]).css({"display":"none"});
        }

        jQuery(post_formats[theSelectedFormat]).css({"display":"block"});
    },

    videoTrigger: function (type) {
        "use strict";

        var iD = jQuery('#PhoenixTeam_video_post_custom_fields'),
            urlBlock    = iD.find('.rwmb-oembed-wrapper'),
            oembedBlock = iD.find('.rwmb-textarea-wrapper');

        switch (type) {
            case 'url':
                oembedBlock.hide();
                urlBlock.show();
                break;
            case 'embed':
                urlBlock.hide();
                oembedBlock.show();
                break;
            default:
                oembedBlock.hide();
                urlBlock.show();
                break;
        }
    },

    audioTrigger: function (type) {
        "use strict";

        var iD = jQuery('#PhoenixTeam_audio_post_custom_fields'),
            urlBlock    = iD.find('.rwmb-oembed-wrapper'),
            fileBlock = iD.find('.rwmb-file_advanced-wrapper');

        switch (type) {
            case 'url':
                fileBlock.hide();
                urlBlock.show();
                break;
            case 'file':
                urlBlock.hide();
                fileBlock.show();
                break;
            default:
                fileBlock.hide();
                urlBlock.show();
                break;
        }
    }

});

jQuery(function() {
    "use strict";

    // post formats trigger
        jQuery("#post-formats-select input:checked").showPostFormats();
        jQuery("#post-formats-select").on("change", function(e) {
            jQuery("#post-formats-select input:checked").showPostFormats();
        });
    // post formats trigger END

    // video trigger
        var v_typeTrigger = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_video_type'),
            type = v_typeTrigger.val(),
            v_urlInput = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_video_url'),
            v_embTextarea = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_video_embed'),
            videoExamples = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_video_url_description').find('a'),
            embedExample = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_video_embed_description').find('a'),
            v_preview = v_urlInput.parent().find('.show-embed');

        videoExamples.each(function(ind, el) {
            jQuery(this).on("click", function(e) {
                e.preventDefault();
                v_urlInput.val(el.text);
                v_preview.click();
            });
        });

        embedExample.on('click', function(e) {
            e.preventDefault();
            v_embTextarea.val("<iframe src='http://www.dailymotion.com/embed/video/xsr67x' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>");
        });

        jQuery.fn.videoTrigger(type);

        v_typeTrigger.change(function() {
            var $this = jQuery(this),
                type = $this.val();
            jQuery.fn.videoTrigger(type);
        });
    // video trigger END

    // audio trigger
        var a_typeTrigger = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_audio_type'),
            a_type = a_typeTrigger.val(),
            a_urlInput = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_audio_url'),
            audioExample = jQuery('#'+ PhoenixTeam.THEME_SLUG +'_postformat_audio_url_description').find('a'),
            a_preview = a_urlInput.parent().find('.show-embed');

        audioExample.on("click", function(e) {
            e.preventDefault();
            a_urlInput.val(jQuery(this).text());
            a_preview.click();
        });

        jQuery.fn.audioTrigger(a_type);

        a_typeTrigger.change(function() {
            var $this = jQuery(this),
                a_type = $this.val();
            jQuery.fn.audioTrigger(a_type);
        });
    // audio trigger END
});
