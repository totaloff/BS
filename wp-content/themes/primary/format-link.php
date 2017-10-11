<?php
    global $PHTlayout;

    $PHTpermalink = get_permalink();
    $PHThas_post_thumb = has_post_thumbnail();

    $PHTlink_url    = rwmb_meta( THEME_SLUG . "_postformat_link_url" );

    $PHTlink = null;
    if ($PHTlink_url) {
        $PHTlink_target = rwmb_meta( THEME_SLUG . "_postformat_link_target" );
        $PHTlink_rel = rwmb_meta( THEME_SLUG . "_postformat_link_rel" );

        if ($PHTlink_target)
            $PHTlink_target =  ' target="'. $PHTlink_target .'"';

        if ($PHTlink_rel)
            $PHTlink_rel = ' rel="'. $PHTlink_rel .'"';

        $PHTlink = '<a href="'. esc_url($PHTlink_url) .'"'. esc_attr( $PHTlink_target ) . esc_attr( $PHTlink_rel ) .'">'. esc_html( get_the_title() ) .'</a>';
    }
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
    <div class="cl-blog-type"><i class="icon-attachment"></i></div>

    <div class="cl-blog-name">
        <?php if ($PHTlink) : ?>
            <?php echo wp_kses(
                $PHTlink,
                array(
                    'a' => array(
                        'href' => array(),
                        'target' => array(),
                        'rel' => array(),
                    )
                ),
                array('http', 'https')
            ); ?>
        <?php else : ?>
            <a href="<?php echo esc_url($PHTpermalink); ?>"><?php the_title(); ?></a>
        <?php endif ?>
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
