<?php
    global $PHTlayout;

    $PHTpermalink = get_permalink();
    $PHThas_post_thumb = has_post_thumbnail();
?>

<?php if ($PHThas_post_thumb) : ?>

    <?php if ($PHTlayout == 'medium') : ?>
        <div class="col-lg-5">
    <?php endif; ?>

        <div class="cl-blog-img">
          <a href="<?php echo esc_url($PHTpermalink) ?>">
            <?php the_post_thumbnail( array( null, null, 'bfi_thumb' => true ) ); ?>
          </a>
        </div>

    <?php if ($PHTlayout == 'medium') : ?>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php if ($PHTlayout == 'medium') : ?>
    <?php if ($PHThas_post_thumb) {
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

<?php if ($PHTlayout == 'medium') : ?>
</div>
<?php endif; ?>
       <div class="col-lg-12"> <div class="cl-blog-line"></div></div>
