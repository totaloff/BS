<?php
    get_header();

    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    $PHTsidebar = isset($PhoenixData['blog_sidebar_position']) ? $PhoenixData['blog_sidebar_position'] : 'right';
    $PHTlayout = isset($PhoenixData['blog_layout']) ? $PhoenixData['blog_layout'] : 'classic';
?>

      <div class="page-in">
              <div class="container">
                <div class="row">

                  <div class="col-lg-6 pull-left">
                    <div class="page-in-name">
<?php
                        echo "<h1>";
                        _e('Archives', THEME_SLUG);
                        echo ":<span>";
                        single_month_title(' ');
                        echo "</span>";
                        echo "</h1>";
?>
                    </div>
                  </div>
<?php
                if ($PHTgen_crumbs) :
                    PhoenixTeam_Utils::breadcrumbs();
                else :
                    echo "<!-- Breadcrumbs turned off -->\n";
                endif;
?>
                </div>
              </div>
            </div>

            <div <?php post_class(array('container', 'general-font-area', 'marg50')); ?>>
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

                    if (have_posts()) {
                        while(have_posts()) {
                            the_post();

                                $PHTpost_format = get_post_format();
                                if (!$PHTpost_format) {
                                    echo '<div class="row '.esc_html($PHTlayout).'-blog post-standard">';
                                    get_template_part( 'format', 'standard' );
                                } else {
                                    echo '<div class="row '.esc_html($PHTlayout).'-blog post-'.$PHTpost_format.'">';
                                    get_template_part( 'format', get_post_format() );
                                }
                                echo '</div>';

                        }

                        echo '<div class="row"><div class="col-lg-12">';
                        PhoenixTeam_Utils::pagination('pride_pg');
                        echo '</div></div>';

                    } else {
?>
                        <div class="container general-font-area marg50">
                            <h1 style="display: block; text-align: center;"><?php _e( 'Sorry, nothing to display.', THEME_TEAM ); ?></h1>
                        </div>
<?php
                    }
?>
                </div>

                    <?php if ($PHTsidebar == 'right') : ?>
                        <!-- sidebar -->
                        <div class="col-lg-3">
                            <?php dynamic_sidebar('blog-sidebar'); ?>
                        </div><!-- sidebar end-->
                    <?php endif; ?>

                </div>

            </div><!-- container marg50 -->

<?php get_footer(); ?>
