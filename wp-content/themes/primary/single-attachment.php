<?php get_header(); ?>

<?php
    global $PhoenixData;
    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    $PHTsidebar = isset($PhoenixData['blog_sidebar_position']) ? $PhoenixData['blog_sidebar_position'] : 'right';
?>

<?php
if (have_posts()) :
    while (have_posts()) :
        the_post();
?>
        <div class="page-in">
          <div class="container">
            <div class="row">

              <div class="col-lg-6 pull-left">
                <div class="page-in-name">
<?php
                    echo "<h1>";
                    _e('Attachment', THEME_SLUG);
                    echo ": <span>". esc_html( get_the_title() ) ."</span>";
                    echo "</h1>";
?>
                </div>
              </div>
<?php
                if ($PHTgen_crumbs) :
                    PhoenixTeam_Utils::breadcrumbs();
                else :
?>
                    <!-- Breadcrumbs turned off -->
<?php
                endif;
?>
            </div>
          </div>
        </div>

        <div id="attachment-<?php the_ID(); ?>" <?php post_class( array('container', 'marg50') ); ?>>
            <div class="row">
<?php
                if ($PHTsidebar == 'no') {
                    echo '<div class="col-lg-12">' . "\n";
                } elseif ($PHTsidebar == 'right') {
                    echo '<div class="col-lg-9">' . "\n";
                } elseif ($PHTsidebar == 'left') {
?>                  <!-- sidebar -->
                    <div class="col-lg-3">
                        <?php dynamic_sidebar('blog-sidebar'); ?>
                    </div><!-- sidebar end-->

                    <div class="col-lg-9">
<?php
                }

                $PHTpermalink = get_permalink();
?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="cl-blog-img">
                        <?php the_post_thumbnail( array( null, null, 'bfi_thumb' => true ) ); ?>
                    </div>
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

                    <div class="cl-blog-text">
                        <div class="entry-attachment">
<?php
                            if ( wp_attachment_is_image( $post->id ) ) :
                                $att_image = wp_get_attachment_image_src( $post->id, "full");
?>
                                <p class="attachment">
                                    <a href="<?php echo esc_attr( wp_get_attachment_url($post->id) ); ?>" title="<?php esc_attr( the_title() ); ?>" rel="attachment"><img data-no-retina="1" src="<?php echo esc_url($att_image[0]);?>" class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a>
                                </p>
                            <?php else : ?>
                                <?php the_content(); ?>
                            <?php endif; ?>
                        </div>

                    </div>

                </div><!-- cl-blog-naz -->

                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo PhoenixTeam_Utils::single_socials(); ?>
                        </div>
                    </div>

                    <div class="cl-blog-line"></div>

                    <!-- comments -->
                    <div>
                        <?php comments_template(); ?>
                    </div>
                    <!-- /comments -->

                </div>

                <?php if ($PHTsidebar == 'right') : ?>
                    <!-- sidebar -->
                    <div class="col-lg-3">
                        <?php dynamic_sidebar('blog-sidebar'); ?>
                    </div><!-- sidebar end-->
                <?php endif; ?>

            </div>
        </div>

    <?php endwhile; ?>

    <?php else: ?>

        <div class="container marg50">
            <h1 style="display: block; text-align: center;"><?php _e( 'Sorry, nothing to display.', THEME_SLUG ); ?></h1>
        </div>

    <?php endif; ?>

<?php get_footer(); ?>
