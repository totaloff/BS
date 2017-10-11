<?php
    # Template Name: Page with Visual Composer
?>

<?php get_header(); ?>

<?php
    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    $PHTsidebar_area = isset($PhoenixData['page_sidebar_widgets_area']) ? $PhoenixData['page_sidebar_widgets_area'] : 'blog-sidebar';
    $PHTsidebar_pos = isset($PhoenixData['page_sidebar_position']) ? $PhoenixData['page_sidebar_position'] : 'no';
    $PHTcomments = isset($PhoenixData['page_display_comments']) ? $PhoenixData['page_display_comments'] : null;
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

        <section <?php post_class('phoenixteam-sidebar-'. esc_attr( $PHTsidebar_pos )); ?>>
            <div id="page-<?php the_ID(); ?>" class="begin-content">
                <section>
<?php
                        if ($PHTsidebar_pos == 'no') {
                            // do nothing
                        } elseif ($PHTsidebar_pos == 'right') {
                            echo '<div class="container marg50">' . "\n";
                                echo '<div class="row">' . "\n";
                                    echo '<div class="col-lg-9 phoenixteam-right-page-layout">' . "\n";

                        } elseif ($PHTsidebar_pos == 'left') {
?>
                            <!-- sidebar -->
                            <div class="container marg50">
                                <div class="row">
                                <div class="col-lg-3 phoenixteam-widget-page-layout">
                                    <?php dynamic_sidebar($PHTsidebar_area); ?>
                                </div><!-- sidebar end-->
                                <div class="col-lg-9 phoenixteam-left-page-layout">
<?php
                        }

                        the_content();

                        if ($PHTsidebar_pos == 'right') : ?>
                                </div>
                                </div>
                                    <!-- sidebar -->
                                    <div class="col-lg-3 phoenixteam-widget-page-layout">
                                        <?php dynamic_sidebar($PHTsidebar_area); ?>
                                    </div><!-- sidebar end-->
                                </div>
                            </div>
                        <?php elseif ($PHTsidebar_pos == 'left') : ?>
                                </div>
                            </div>
                        <?php endif; ?>
                </section>
            </div>
        </section>



<?php
        }
    }
?>

<?php get_footer(); ?>
