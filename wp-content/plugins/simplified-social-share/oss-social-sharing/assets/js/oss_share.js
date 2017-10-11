jQuery(document).ready(function() {
    jQuery(".oss_title_replace").each(function() {
        jQuery(this).attr('data-share-title',jQuery(this).attr('data-share-titles'));
        jQuery(this).removeAttr('data-share-titles');
    });
});
