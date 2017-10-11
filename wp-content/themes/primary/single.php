<?php get_header(); ?>

<?php
  global $PhoenixData;

  $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
  $PHTsidebar_area = isset($PhoenixData['blog_sidebar_widgets_area']) ? $PhoenixData['blog_sidebar_widgets_area'] : 'blog-sidebar';
  $PHTsidebar_pos = isset($PhoenixData['blog_sidebar_position']) ? $PhoenixData['blog_sidebar_position'] : 'right';
?>

<?php
if (have_posts()) :
  while (have_posts()) :
    the_post();

    $PHTpost_title_section = rwmb_meta(THEME_SLUG . "_post_title_section");

    if ($PHTpost_title_section === '' || $PHTpost_title_section === "1") :

      $PHTpost_subtitle	=	rwmb_meta(THEME_SLUG . '_subtitle');
      $PHTpost_crumbs	=	rwmb_meta(THEME_SLUG . '_post_breadcrumbs');
?>
      <div class="page-in">
        <div class="container">
          <div class="row">

            <div class="col-lg-6 pull-left">
              <div class="page-in-name">
<?php
                  echo "<h1>";
                    the_title();

                if ($PHTpost_subtitle)
                  echo ": <span>". esc_html( $PHTpost_subtitle ) ."</span>";

                echo "</h1>";
?>
              </div>
            </div>
<?php
          if ($PHTgen_crumbs && $PHTpost_crumbs === '-1') :

            PhoenixTeam_Utils::breadcrumbs();

          elseif ($PHTpost_crumbs === '1') :

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

<?php endif; ?>

    <div id="<?php the_ID(); ?>" <?php post_class( array('container', 'general-font-area', 'marg50') ); ?>>
      <div class="row">
<?php
                if ($PHTsidebar_pos == 'no') {
                    echo '<div class="col-lg-12">' . "\n";
                } elseif ($PHTsidebar_pos == 'right') {
                    echo '<div class="col-lg-9">' . "\n";
                } elseif ($PHTsidebar_pos == 'left') {
?>                  <!-- sidebar -->
                    <div class="col-lg-3">
                        <?php dynamic_sidebar($PHTsidebar_area); ?>
                    </div><!-- sidebar end-->

                    <div class="col-lg-9">
<?php
                }

          $PHTpost_format = get_post_format();
          if (!$PHTpost_format) $PHTpost_format = 'standard';

          get_template_part( 'format', $PHTpost_format );

?>
          <div class="col-lg-12">
            <div class="wp-link-pages-container">
              <?php
                $PHTlink_pages_args = array(
                  'before'           => '<div class="pride_pg">',
                  'after'            => '</div>',
                  'link_before'      => '',
                  'link_after'       => '',
                  'next_or_number'   => 'number',
                  'nextpagelink'     => __('Next', THEME_SLUG),
                  'previouspagelink' => __('Prev', THEME_SLUG),
                  'pagelink'         => '%',
                  'echo'             => 1
                );
                wp_link_pages($PHTlink_pages_args);
              ?>
            </div>
          </div>

          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="tags-blog-single">
                    <?php the_tags('<ul class="tags-blog"><li>','</li><li>','</li></ul>'); ?>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <?php echo PhoenixTeam_Utils::single_socials(); ?>
              </div>
          </div>

          <div class="author-bio">
            <div class="img-author"><?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?></div>
            <div class="name-author"><?php _e('About author:', THEME_SLUG); ?> <?php the_author_posts_link(); ?></div>
            <div class="text-author">
              <?php the_author_meta('description'); ?>
            </div>
          </div>
          <div class="row">
            <div class="prev-next-links-wrapper">
              <?php if (get_previous_post_link()) : ?>
                <div class="col-lg-4 col-xs-4 pull-left">
                  <span class="btn-item pull-left">
                    <?php previous_post_link('%link', __('Prev', THEME_SLUG)); ?>
                  </span>
                </div>
              <?php endif; ?>
              <?php if (get_next_post_link()) : ?>
                <div class="col-lg-4 col-xs-4 pull-right">
                  <span class="btn-item pull-right">
                    <?php next_post_link('%link', __('Next', THEME_SLUG)); ?>
                  </span>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="cl-blog-line"></div>

          <!-- comments -->
          <div>
            <?php comments_template(); ?>
          </div>
          <!-- /comments -->

        </div>

        <?php if ($PHTsidebar_pos == 'right') : ?>
            <!-- sidebar -->
            <div class="col-lg-3">
                <?php dynamic_sidebar($PHTsidebar_area); ?>
            </div><!-- sidebar end-->
        <?php endif; ?>

      </div>
    </div>

  <?php endwhile; ?>

  <?php else: ?>

    <div class="container general-font-area marg50">
        <h1 style="display: block; text-align: center;"><?php _e( 'Sorry, nothing to display.', THEME_SLUG ); ?></h1>
    </div>

  <?php endif; ?>

<?php get_footer(); ?>
