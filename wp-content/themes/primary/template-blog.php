<?php
    # Template name: Blog

    get_header();

    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    $PHTsidebar_area = isset($PhoenixData['blog_sidebar_widgets_area']) ? $PhoenixData['blog_sidebar_widgets_area'] : 'blog-sidebar';
    $PHTsidebar_pos = isset($PhoenixData['blog_sidebar_position']) ? $PhoenixData['blog_sidebar_position'] : 'right';
    $PHTlayout = isset($PhoenixData['blog_layout']) ? $PhoenixData['blog_layout'] : 'classic';
?>

<?php
    if (have_posts()) {
        while(have_posts()) {
            the_post();

            $PHTpage_subtitle  =   rwmb_meta(THEME_SLUG . '_subtitle');
            $PHTpage_crumbs    =   rwmb_meta(THEME_SLUG . '_page_breadcrumbs');
            $PHTpage_layout    =   rwmb_meta(THEME_SLUG . '_page_layout');
            $PHTpage_area      =   rwmb_meta(THEME_SLUG . '_page_widgets_area');

            if ($PHTpage_layout && $PHTpage_layout != $PHTsidebar_pos)
                $PHTsidebar_pos = $PHTpage_layout;

            if ($PHTpage_area && $PHTpage_area != $PHTsidebar_area)
                $PHTsidebar_area = $PHTpage_area;
?>
            <div class="page-in"><div>

              <div class="container">
                <div class="row">

                  <div class="col-lg-6 pull-left">
                    <div class="page-in-name">
<?php
                        echo "<h1>";
                            the_title();

                        if ($PHTpage_subtitle)
                            echo ": <span>". esc_html( $PHTpage_subtitle ) ."</span>";

                        echo "</h1>";
?>
                    </div>
                  </div>
<?php
                if ($PHTgen_crumbs && $PHTpage_crumbs !== '0' || $PHTgen_crumbs && $PHTpage_crumbs === '-1') :

                    PhoenixTeam_Utils::breadcrumbs();

                elseif ($PHTpage_crumbs === '1') :

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
        </div>

            <div <?php post_class(array('container', 'general-font-area', 'marg50')); ?>>
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

                the_content();
        }
        wp_reset_postdata();
    }

    $PHTquery_args = array(
        'post_type' => 'post',
        'posts_per_page' => get_option('posts_per_page'),
        'post_status' => array('publish', 'private'),
        'paged' => get_query_var('paged')
    );

    $PHTquery = new WP_Query($PHTquery_args);

    if ($PHTquery->have_posts()) {
        while($PHTquery->have_posts()) {
            $PHTquery->the_post();

                $PHTis_sticky = is_sticky() ? 'sticky-lou' : null;

                $PHTpost_format = get_post_format();
                if (!$PHTpost_format) {
                    echo '<div class="'. implode(' ', get_post_class(array('row', esc_attr($PHTlayout) .'-blog', 'post-standard', $PHTis_sticky))) .'">';
                    get_template_part( 'format', 'standard' );
                } else {
                    echo '<div class="'. implode(' ', get_post_class(array('row', esc_attr($PHTlayout).'-blog', 'post-'.$PHTpost_format, $PHTis_sticky ))).'">';
                    get_template_part( 'format', get_post_format() );
                }
                echo '</div>';

        }


        echo '<div class="row"><div class="col-lg-12">';
        PhoenixTeam_Utils::pagination('pride_pg', $PHTquery);
        echo '</div></div>';
    }

?>
            </div>

        <?php if ($PHTsidebar_pos == 'right') : ?>
            <!-- sidebar -->
            <div class="col-lg-3">
                <?php dynamic_sidebar($PHTsidebar_area); ?>
            </div><!-- sidebar end-->
        <?php endif; ?>

        </div>

        </div><!-- container marg50 -->

<?php get_footer(); ?>
