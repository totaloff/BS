<?php
    # Template name: Portfolio

    get_header();

    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    // $PHTsidebar = isset($PhoenixData['port_sidebar_position']) ? $PhoenixData['port_sidebar_position'] : 'no';
    $quantity = isset($PhoenixData['port_quantity']) ? $PhoenixData['port_quantity'] : 8;
    $PHTport_layout = isset($PhoenixData['port_layout']) ? $PhoenixData['port_layout'] : '3-cols';
?>

<?php
    if (have_posts()) {
        while(have_posts()) {
            the_post();

            $PHTpage_subtitle  =   rwmb_meta(THEME_SLUG . '_subtitle');
            $PHTpage_crumbs    =   rwmb_meta(THEME_SLUG . '_page_breadcrumbs');
            $PHTport_cat       =   rwmb_meta(THEME_SLUG . '_page_portfolio_cat');
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
                    <div class="col-lg-12">
                        <div id="filters-container-portfolio" class="cbp-l-filters-button"<?php if ($PHTport_layout == 'full') echo ' style="display:table;margin:auto;"'; ?>>
<?php
                            if ($PHTport_cat && $PHTport_cat != 'none') {
                                $PHTcats = get_terms( THEME_SLUG . '_portfolio_category', 'orderby=count&hide_empty=1&child_of=' . $PHTport_cat );
                            } else {
                                $PHTcats = get_terms( THEME_SLUG . '_portfolio_category', 'orderby=count&hide_empty=1' );
                            }

                            $PHTto_return = array();
                            $PHTto_return[] = '<button data-filter="*" class="cbp-filter-item cbp-filter-item-active">'. __("All", THEME_SLUG) .'<div class="cbp-filter-counter"></div></button>';

                            foreach ($PHTcats as $cat) {
                                $term = get_term_by( 'id', $cat->term_id, THEME_SLUG . '_portfolio_category' );
                                $PHTto_return[] = '<button data-filter=".'. $term->slug .'" class="cbp-filter-item">'. $term->name .'<div class="cbp-filter-counter"></div></button>';
                            }

                            echo implode("\n", $PHTto_return);
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="marg50 general-font-area<?php if ($PHTport_layout != 'full') echo " container"; ?>">
                <div class="row">
                    <div class="col-lg-12">
<?php
                        the_content();
        }
        wp_reset_postdata();
    }
?>
                    </div><!-- col-any -->
                </div><!-- row -->
<?php
    $PHTajaxPaged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $PHTquery_args = array(
        'post_type' => THEME_SLUG . '_portfolio',
        'posts_per_page' => $quantity,
        'post_status' => 'publish',
        'paged' => $PHTajaxPaged,
    );

    if ($PHTport_cat && $PHTport_cat != 'none') {
        $PHTquery_args['tax_query'] = array(
            array(
                'taxonomy' => THEME_SLUG . '_portfolio_category',
                'field'    => 'term_id',
                'include_children' => true,
                'terms' => $PHTport_cat
            )
        );
    }

    $PHTquery = new WP_Query($PHTquery_args);

    if ($PHTquery->have_posts($PHTquery->query_vars)) {

        echo '<script>'.THEME_TEAM.'["queryVars"] = \''. serialize($PHTquery->query_vars) .'\'; '.THEME_TEAM.'["currentPage"] = '. $PHTajaxPaged .';</script>';
?>
        <div class="phoenix-shortcode-portfolio-grid portfolio-grey">
            <div class="cbp-l-grid-projects" id="grid-container-portfolio">
                <ul>
<?php
        while($PHTquery->have_posts()) {
            $PHTquery->the_post();

            $ID = get_the_id();

            $the_cat = get_the_terms( $ID , THEME_SLUG . '_portfolio_category');
            $categories = '';
            if (is_array($the_cat)) {
                foreach($the_cat as $cur_term) {
                    $categories .= $cur_term->slug . ' ';
                }
            }

            $PHTthumb_params = array('width' => 800,'height' => 600, 'crop' => true);
            $PHTthumb = null;

            $PHTtitle = get_the_title();
            $PHTauthor = rwmb_meta(THEME_SLUG . '_portfolio_author');

            if (has_post_thumbnail()) {
                $PHTthumb = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full', true );
                $PHTthumb = $PHTthumb[0];
            } else {
                $PHTthumb = THEME_URI . "/assets/images/nopicture.png";
            }
?>
            <li class="cbp-item <?php echo $categories; ?>">
                <div class="cbp-item-wrapper">
                    <div class="portfolio-phoenixteam"><div class="portfolio-image"><?php if ($PHTthumb) echo '<img data-no-retina="1" src="'. bfi_thumb( $PHTthumb, $PHTthumb_params ) .'" alt="'. esc_attr( $PHTtitle ) .'" />'; ?>
                        <figcaption>
                            <p class="icon-links">
                                <a href="<?php echo site_url() . "/wp-admin/admin-ajax.php?p=" . esc_attr($ID); ?>" class="cbp-singlePageInline"><i class="icon-attachment"></i></a>
                                <a href="<?php echo esc_url($PHTthumb); ?>" class="cbp-lightbox" data-title="<?php echo esc_attr( $PHTtitle ); ?>"><i class="icon-magnifying-glass"></i></a>
                            </p>
                        </figcaption>
                    </div>
                    <h2><?php echo esc_html( $PHTtitle ); ?></h2>
                    <p>by <?php echo esc_html( $PHTauthor ); ?></p>
                    </div>
                </div>
            </li>
<?php
        }
                echo '</ul></div>
                <div class="col-lg-12">
                  <div class="button-center"><a href="#" class="btn-simple cbp-l-loadMore-button-link">'. __('Load Full Portfolio', THEME_SLUG) .'</a></div>
                </div>

                </div>';
    }
?>
            </div>

<?php get_footer(); ?>
