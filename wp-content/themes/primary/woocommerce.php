<?php
    get_header();

    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : true;
    $PHTis_shop = is_shop();
    $ID = woocommerce_get_page_id('shop');
    $PHTpage_crumbs = rwmb_meta(THEME_SLUG . '_page_breadcrumbs', "", $ID) ? rwmb_meta(THEME_SLUG . '_page_breadcrumbs', "", $ID) : $PHTgen_crumbs;
    $PHTsidebar_pos = rwmb_meta(THEME_SLUG . '_page_layout', "", $ID) ? rwmb_meta(THEME_SLUG . '_page_layout', "", $ID) : 'right';
    $PHTsidebar_ar  = rwmb_meta(THEME_SLUG . '_page_widgets_area', "", $ID) ? rwmb_meta(THEME_SLUG . '_page_widgets_area', "", $ID) : 'woo-sidebar';
    $PHTpage_header = rwmb_meta(THEME_SLUG . '_page_header_bg', array('type' => 'image_advanced'), $ID);
    $PHTheader_adv = rwmb_meta(THEME_SLUG . '_page_header_advanced', "", $ID);

    if ($PHTheader_adv) {
        $PHTpage_bgcol  = rwmb_meta(THEME_SLUG . '_page_header_bgcol', "", $ID);
        $PHTbgcol_opac  = rwmb_meta(THEME_SLUG . '_page_header_bgcol_opacity', "", $ID);
        $PHTtitle_col   = rwmb_meta(THEME_SLUG . '_page_title_col', "", $ID);
    } else {
        $PHTpage_bgcol = $PHTbgcol_opac = $PHTtitle_col = null;
    }

    $PHTbg_css = null;

    if (!$PHTis_shop)
        $ID = $post->ID;

    $PHTpage_subtitle  =   rwmb_meta(THEME_SLUG . '_subtitle', "", $ID);

    if ($PHTpage_header) {
        $PHTbg_css = ' style="';

        $PHTpage_header = array_shift($PHTpage_header);
        $PHTpage_header = 'background: url('. esc_url($PHTpage_header['full_url']) .') center repeat;';

        if ($PHTtitle_col)
            $PHTtitle_col = 'color:'. $PHTtitle_col .';';

        if ($PHTpage_bgcol) {

            if ($PHTbgcol_opac && $PHTbgcol_opac != 1) {
                $PHTpage_bgcol = PhoenixTeam_Utils::hex_to_rgb($PHTpage_bgcol);
                $PHTpage_bgcol = 'rgba('. $PHTpage_bgcol .','. $PHTbgcol_opac .')';
            }

            $PHTpage_bgcol = '<div style="background-color: '. $PHTpage_bgcol .';">';
        } else {
            $PHTpage_bgcol = '<div>';
        }

        $PHTbg_css .= $PHTpage_header . $PHTtitle_col;

        $PHTbg_css .= '"';

        echo '<div class="page-in" '. esc_html( $PHTbg_css ) .'>' . esc_html( $PHTpage_bgcol );
    } else {
        echo '<div class="page-in"><div>';
    }
?>
              <div class="container">
                <div class="row">

                  <div class="col-lg-6 pull-left">
                    <div class="page-in-name">
<?php
                        if ($PHTis_shop)
                            woocommerce_page_title();
                        else
                            echo esc_html( get_the_title() );

                        if ($PHTpage_subtitle)
                            echo ": <span>". esc_html( $PHTpage_subtitle ) ."</span>";
?>
                    </div>
                  </div>
<?php
                if ($PHTgen_crumbs && $PHTpage_crumbs !== '0' || $PHTgen_crumbs && $PHTpage_crumbs === '-1') :
                    PhoenixTeam_Utils::breadcrumbs();
                elseif ($PHTpage_crumbs === '1') :
                    PhoenixTeam_Utils::breadcrumbs();
                else :
                    echo "<!-- Breadcrumbs turned off -->";
                endif;
?>
                </div>
              </div>
            </div>
        </div>

            <section id="woocommerce_page" class="marg50 container general-font-area<?php echo ' phoenixteam-sidebar-'. esc_attr( $PHTsidebar_pos ); ?>">
                <div>
<?php
                if ($PHTsidebar_pos == 'no') {
                    echo '<div class="col-lg-12">' . "\n";
                } elseif ($PHTsidebar_pos == 'right') {
                    echo '<div class="row">' . "\n";
                    echo '<div class="col-lg-9">' . "\n";
                } elseif ($PHTsidebar_pos == 'left') {
?>
                    <!-- sidebar -->
                    <div class="row">
                    <div class="col-lg-3">
                        <?php dynamic_sidebar($PHTsidebar_ar); ?>
                    </div><!-- sidebar end-->

                    <div class="col-lg-9">
<?php
                }

                woocommerce_content();
?>


<?php
                if ($PHTsidebar_pos == 'right') :
?>
                        </div>
                        <!-- sidebar -->
                        <div class="col-lg-3">
                            <?php dynamic_sidebar($PHTsidebar_ar); ?>
                        </div><!-- sidebar end-->
                    </div>
                <?php elseif ($PHTsidebar_pos == 'left') : ?>
                    </div>
                <?php endif; ?>

            </div>
            </section>

<?php get_footer(); ?>
