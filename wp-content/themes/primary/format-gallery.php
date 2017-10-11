<?php
    global $PHTlayout;

    $ID = get_the_id();
    $PHTpermalink = get_permalink();

    $PHTthumb = null;
    if (has_post_thumbnail()) {
        $PHTthumb = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full', true );
        $PHTthumb = array('full_url' => esc_url($PHTthumb[0]));
    }

    $PHTgallery = rwmb_meta( THEME_SLUG . "_postformat_gallery", array('type' => 'image_advanced') );

    if ($PHTthumb)
        array_unshift($PHTgallery, $PHTthumb);
?>

<?php if (count($PHTgallery)) : ?>

    <?php if ($PHTlayout == 'medium') : ?>
        <div class="col-lg-5">
    <?php endif; ?>
        <a href="<?php echo esc_url($PHTpermalink) ?>">
          <ul id="bxslider-<?php echo esc_attr($ID); ?>" class="bxslider">
<?php
              foreach ($PHTgallery as $item) {;
                  echo '<li><img data-no-retina="1" src="'. esc_url($item['full_url']) .'" alt=""></li>';
              }
?>
          </ul>
        </a>

        <!-- bxslider init -->
        <script type="text/javascript">
            jQuery(function() {
                jQuery('#bxslider-<?php echo esc_js($ID); ?>').bxSlider({
                    adaptiveHeight: true,
                    mode: 'fade',
                    slideMargin: 0,
                    pager: false,
                    controls: true
                });
            });
        </script>

    <?php if ($PHTlayout == 'medium') : ?>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php if ($PHTlayout == 'medium') : ?>
    <?php if (count($PHTgallery)) {
            echo '<div class="col-lg-7">';
        } else {
            echo '<div class="col-lg-12">';
        }
    ?>
<?php endif; ?>

<div class="cl-blog-naz">
    <div class="cl-blog-type"><i class="icon-camera"></i></div>

    <div class="cl-blog-name">
        <a href="<?php echo esc_url($PHTpermalink); ?>"><?php the_title(); ?></a>
    </div >
    <div class="cl-blog-detail">
        <?php the_time('j F Y'); ?> - <?php the_time('G:i'); ?>,
        <?php _e('by', THEME_SLUG); ?> <?php the_author_posts_link(); ?>,
        <?php _e('in', THEME_SLUG); ?> <?php the_category(', '); ?>, <?php comments_popup_link( __('No comments', THEME_SLUG), __('1 comment', THEME_SLUG), __( '% comments', THEME_SLUG), null, __('Comments off', THEME_SLUG) ); ?>
    </div>

    <?php if ( is_single() ) : ?>
        <div class="cl-blog-text">
            <?php the_content(); ?>
        </div>

</div><!-- cl-blog-naz -->
    <?php else : ?>
        <div class="cl-blog-text">
            <?php echo get_the_excerpt(); ?>
        </div>

</div><!-- cl-blog-naz -->
    <div style="overflow: hidden; width: 100%;">
        <div class="cl-blog-read"><a href="<?php echo esc_url($PHTpermalink); ?>"><?php _e('Read More', THEME_SLUG); ?></a></div>
    </div>
    <?php endif; ?>
    <br clear="all" />
<?php if ($PHTlayout == 'medium') : ?>
</div>
<?php endif; ?>
       <div class="col-lg-12"> <div class="cl-blog-line"></div></div>
