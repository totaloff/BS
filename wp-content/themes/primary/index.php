<?php
    get_header();

    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    $PHTsidebar = isset($PhoenixData['blog_sidebar_position']) ? $PhoenixData['blog_sidebar_position'] : 'right';
    $PHTlayout = isset($PhoenixData['blog_layout']) ? $PhoenixData['blog_layout'] : 'classic';

    $PHTpage = PhoenixTeam_Utils::check_posts_page();
?>

<?php
    if ($PHTpage) {
            $PHTpage_subtitle  =   rwmb_meta(THEME_SLUG . '_subtitle', null, $PHTpage->ID);
            $PHTpage_crumbs    =   rwmb_meta(THEME_SLUG . '_page_breadcrumbs', null, $PHTpage->ID);
?>
            <div class="page-in">
              <div class="container">
                <div class="row">

                  <div class="col-lg-6 pull-left">
                    <div class="page-in-name">
<?php
                        echo "<h1>";
                        echo esc_html( $PHTpage->post_title );

                        if ($PHTpage_subtitle)
                            echo ": <span>". esc_html( $PHTpage_subtitle ) ."</span>";

                        echo "</h1>";
?>
                    </div>
                  </div>
<?php
                if ($PHTgen_crumbs && $PHTpage_crumbs === '-1') :

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

        echo $PHTpage->post_content;

        wp_reset_postdata();
    } else {
?>
            <div class="container general-font-area marg50">
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
    } // if (page) END


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
        $PHTpagination = PhoenixTeam_Utils::pagination('pride_pg', $PHTquery);
        if (!$PHTpagination) posts_nav_link();
        echo '</div></div>';
    } else {
?>
        <div class="container marg50">
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
