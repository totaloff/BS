<?php
    global $PHTlayout;

    $PHTpermalink = get_permalink();
    $PHTtype = rwmb_meta(THEME_SLUG . '_postformat_audio_type');
    $PHThas_post_thumb = has_post_thumbnail();

    if ($PHTtype == 'url') {
        $PHTaudio = rwmb_meta(THEME_SLUG . '_postformat_audio_url');
        $PHTaudio = PhoenixTeam_Utils::embed_url($PHTaudio);
    } elseif ($PHTtype == 'file') {
        $PHTaudio = rwmb_meta(THEME_SLUG . '_postformat_audio_file');
        $PHTaudio = wp_get_attachment_url($PHTaudio);
    } else {
        $PHTaudio = false;
    }
?>

<?php if ($PHTlayout == 'medium') : ?>
    <div class="col-lg-5">
<?php endif; ?>

    <?php if ($PHTaudio && $PHTtype == 'url') : ?>
        <div class="video-container">
            <?php echo wp_kses(
                $PHTaudio,
                array(
                    'iframe' => array(
                        'src' => array(),
                        'frameborder' => array(),
                        'title' => array(),
                        'allowFullScreen' => array(),
                        'webkitAllowFullScreen' => array(),
                        'mozallowfullscreen' => array(),
                    )
                ),
                array('http', 'https')
            ); ?>
        </div>
    <?php endif; ?>
    <?php if ($PHTaudio && $PHTtype == 'file') : ?>
        <?php if ($PHThas_post_thumb) : ?>
        <div class="cl-blog-img">
            <a href="<?php echo esc_url($PHTpermalink) ?>">
              <?php the_post_thumbnail( array( null, null, 'bfi_thumb' => true ) ); ?>
            </a>
        </div>
        <?php endif; ?>
        <?php echo do_shortcode('[audio src="'. esc_url($PHTaudio) .'"]'); ?>
    <?php endif; ?>

<?php if ($PHTlayout == 'medium') : ?>
    </div>
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
    <div class="cl-blog-type"><i class="icon-megaphone"></i></div>

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
