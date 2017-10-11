<?php get_header(); ?>

<?php
    global $PhoenixData;

    $PHTgen_crumbs = isset($PhoenixData['breadcrumbs']) ? $PhoenixData['breadcrumbs'] : null;
    $PHTrelated_qty = isset($PhoenixData['port_related_quantity']) ? $PhoenixData['port_related_quantity'] : 6;
    $PHTlayout = isset($PhoenixData['port_single_layout']) ? $PhoenixData['port_single_layout'] : 'wide';
    $PHTlayout = esc_html( $PHTlayout );

    if ($PHTlayout == 'wide') {
        $PHTlayout_class = 'col-lg-12';
    } elseif ($PHTlayout == 'half') {
        $PHTlayout_class = 'col-lg-9';
    }

    $PHTthisID = array();
?>

<?php
if (have_posts()) :
    while (have_posts()) :
        the_post();

        $PHTpost_subtitle  =   rwmb_meta(THEME_SLUG . '_subtitle');
        $PHTpost_crumbs    =   rwmb_meta(THEME_SLUG . '_port_breadcrumbs');
        $PHTport_cat       =   rwmb_meta(THEME_SLUG . '_portfolio_recent_works_cat');
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
                    echo "<!-- Breadcrumbs turned off -->\n";
                endif;
?>
            </div>
          </div>
        </div>

<?php
        $PHT_ID = get_the_id();
        $PHTthisID[] = $PHT_ID;

        $PHTthumb = null;
        if (has_post_thumbnail()) {
            $PHTthumb = wp_get_attachment_image_src( get_post_thumbnail_id($PHT_ID), 'full', true );
            $PHTthumb = array('full_url' => $PHTthumb[0]);
        }

        $PHTGallery = rwmb_meta( THEME_SLUG . '_portfolio_gallery', array('type' => 'image_advanced') );

        if ($PHTthumb)
            array_unshift($PHTGallery, $PHTthumb);

        $PHTName = esc_html( get_the_title() );
        if ($PHTName) {
            $PHTName = '<li>'. __('Name', THEME_SLUG) .': '. $PHTName .'</li>';
        }

        $PHTDate = rwmb_meta(THEME_SLUG . '_portfolio_date');
        if ($PHTDate) {
            $PHTDate = '<li>'. __('Date', THEME_SLUG) .': '. esc_html( $PHTDate ) .'</li>';
        }

        $PHTCategory = get_the_terms($PHT_ID, THEME_SLUG . '_portfolio_category');
        if ($PHTCategory) {
            $PHTCategory = array_reverse($PHTCategory);
            $PHTCategory = $PHTCategory[0]->name;
            $PHTCategory = '<li>'. __('Category', THEME_SLUG) .': '. esc_html( $PHTCategory ) .'</li>';
        }

        $PHTDescription = rwmb_meta(THEME_SLUG . '_portfolio_description');
        $PHTAuthor = rwmb_meta(THEME_SLUG . '_portfolio_author');
        $PHTAuthorUrl = rwmb_meta(THEME_SLUG . '_portfolio_author_url');
        $PHTClient = rwmb_meta(THEME_SLUG . '_portfolio_client');
        $PHTClientUrl = rwmb_meta(THEME_SLUG . '_portfolio_client_url');

        if ($PHTAuthorUrl && $PHTAuthor) {
            $PHTAuthor = '<li>'. __('Author', THEME_SLUG) . ': <a href="'. esc_url($PHTAuthorUrl) .'">'. esc_html( $PHTAuthor ) .'</a></li>';
        } elseif($PHTAuthor) {
            $PHTAuthor = '<li>'. __('Author', THEME_SLUG) . ': '. esc_html( $PHTAuthor ) .'</li>';
        } else {
            $PHTAuthor = null;
        }

        if ($PHTClientUrl && $PHTClient) {
            $PHTClient = '<li>'. __('Client', THEME_SLUG) . ': <a href="'. esc_html( $PHTClientUrl ) .'">' . esc_html( $PHTClient ) .'</a></li>';
        } elseif ($PHTClient) {
            $PHTClient = '<li>'. __('Client', THEME_SLUG) . ': ' . esc_html( $PHTClient ) .'</li>';
        } else {
            $PHTClient = null;
        }

        $PHTprev_post = get_previous_post();
        if ($PHTprev_post)
            $PHTprev_post = get_permalink($PHTprev_post->ID);

        $PHTnext_post = get_next_post();
        if ($PHTnext_post)
            $PHTnext_post = get_permalink($PHTnext_post->ID);
?>

        <div id="<?php echo $PHT_ID; ?>" <?php post_class( array('container', 'general-font-area', 'marg50') ); ?>>
            <div class="row">
                <div class="<?php echo $PHTlayout_class; ?>">

                        <div id="main">
                                    <?php if (count($PHTGallery)) : ?>
                                        <ul class="bxslider">
<?php
                                            foreach ($PHTGallery as $item) {;
                                                echo '<li><img data-no-retina="1" src="'. esc_url($item['full_url']) .'" alt=""></li>';
                                            }
?>
                                    </ul>
                                    <?php endif; ?>
                        </div>
                </div>


<?php if ($PHTlayout == 'wide') : ?>

            <?php if ($PHTprev_post) : ?>
                <div class="col-lg-4 col-xs-4 pull-left"><a href="<?php echo esc_url($PHTprev_post); ?>" class="btn-item pull-left">&laquo; <?php _e('Prev', THEME_SLUG); ?></a></div>
            <?php endif; ?>
            <!-- <div class="col-lg-4 col-xs-4"><div class="item-heart"><i class="icon-heart"></i></div></div> -->
            <?php if ($PHTnext_post) : ?>
                <div class="col-lg-4 col-xs-4 pull-right"><a href="<?php echo esc_url($PHTnext_post); ?>" class="btn-item pull-right"><?php _e('Next', THEME_SLUG); ?> &raquo;</a></div>
            <?php endif; ?>

            </div>

                <div class="row marg25">
                    <div class="col-lg-3">
                        <ul class="portfolio-item">
                          <?php echo $PHTName; ?>
                          <?php echo $PHTDate; ?>
                          <?php echo $PHTCategory; ?>
                          <?php echo $PHTAuthor; ?>
                          <?php echo $PHTClient; ?>
                        </ul>
                    </div>
                    <div class="col-lg-9">
                        <ul class="portfolio-item">
                          <li><?php _e('Description', THEME_SLUG) ?>:</li>
                        </ul>
                        <div class="portfolio-item-text">
                            <?php echo wp_kses_post( $PHTDescription ); ?>
                        </div>
                    </div>
                </div>

<?php elseif ($PHTlayout == 'half') : ?>

                <div class="col-lg-3">
                  <ul class="portfolio-item">
                    <?php echo $PHTName; ?>
                    <?php echo $PHTDate; ?>
                    <?php echo $PHTCategory; ?>
                    <?php echo $PHTAuthor; ?>
                    <?php echo $PHTClient; ?>
                  </ul>

                  <div class="row">
                    <?php if ($PHTprev_post) : ?>
                        <div class="col-lg-4 col-xs-4 pull-left"><a href="<?php echo esc_url($PHTprev_post); ?>" class="btn-item pull-left">&laquo; <?php _e('Prev', THEME_SLUG); ?></a></div>
                    <?php endif; ?>
                    <!-- <div class="col-lg-4 col-xs-4"><div class="item-heart"><i class="icon-heart"></i></div></div> -->
                    <?php if ($PHTnext_post) : ?>
                        <div class="col-lg-4 col-xs-4 pull-right"><a href="<?php echo esc_url($PHTnext_post); ?>" class="btn-item pull-right"><?php _e('Next', THEME_SLUG); ?> &raquo;</a></div>
                    <?php endif; ?>
                  </div>
                </div>

            </div>

            <div class="row marg25">
                <div class="col-lg-12">
                    <ul class="portfolio-item">
                        <li><?php _e('Description', THEME_SLUG) ?>:</li>
                    </ul>
                    <div class="portfolio-item-text">
                        <?php echo wp_kses_post( $PHTDescription ); ?>
                    </div>
                </div>
            </div>



<?php endif; ?>

            <div class="container marg75">
              <div class="row">
                <div class="col-lg-12">
                  <div class="promo-block">
                    <div class="promo-text"><?php _e('Recent Works', THEME_SLUG); ?></div>
                    <div class="center-line"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="container general-font-area marg50">
<?php
    $PHTajaxPaged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $PHTquery_args = array(
        'post_type' => THEME_SLUG . '_portfolio',
        'posts_per_page' => $PHTrelated_qty,
        'post_status' => 'publish',
        'paged' => $PHTajaxPaged,
        'post__not_in' => $PHTthisID
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

    if ($PHTquery->have_posts()) {

        echo '<script>portSetts = {inlineError: "'.__("Error! Please refresh the page!", THEME_SLUG).'", moreLoading: "'.__("Loading...", THEME_SLUG).'", moreNoMore: "'.__("No More Works", THEME_SLUG).'"}; '.THEME_TEAM.'["queryVars"] = \''. serialize($PHTquery->query_vars) .'\'; '.THEME_TEAM.'["currentPage"] = '. $PHTajaxPaged .';</script> ' . "\n";
?>
        <div class="phoenix-shortcode-portfolio-grid portfolio-grey">
            <div class="cbp-l-grid-projects" id="grid-container-portfolio">
                <ul>
<?php
        while($PHTquery->have_posts()) {
            $PHTquery->the_post();

            $PHT_ID = get_the_id();

            $PHTthe_cat = get_the_terms( $PHT_ID , THEME_SLUG . '_portfolio_category');
            $PHTcategories = '';
            if (is_array($PHTthe_cat)) {
                foreach($PHTthe_cat as $cur_term) {
                    $PHTcategories .= $cur_term->slug . ' ';
                }
            }

            $PHTthumb_params = array('width' => 800,'height' => 600, 'crop' => true);
            $PHTthumb = null;

            $PHTtitle = esc_html( get_the_title() );
            $PHTauthor = rwmb_meta(THEME_SLUG . '_portfolio_author');
            $link = get_permalink();

            if (has_post_thumbnail()) {
                $PHTthumb = wp_get_attachment_image_src( get_post_thumbnail_id($PHT_ID), 'full', true );
                $PHTthumb = $PHTthumb[0];
            } else {
                $PHTthumb = THEME_URI . "/assets/images/nopicture.png";
            }
?>

            <li class="cbp-item <?php echo esc_attr( $PHTcategories ); ?>">
                <div class="cbp-item-wrapper">
                    <div class="portfolio-phoenixteam"><div class="portfolio-image"><?php if ($PHTthumb) echo '<img data-no-retina="1" src="'. bfi_thumb( $PHTthumb, $PHTthumb_params ) .'" alt="'. esc_attr( $PHTtitle ) .'" />'; ?>
                        <figcaption>
                            <p class="icon-links">
                                <a href="<?php echo site_url() . "/wp-admin/admin-ajax.php?p={$PHT_ID}"; ?>" class="cbp-singlePageInline"><i class="icon-attachment"></i></a>
                                <a href="<?php echo $PHTthumb; ?>" class="cbp-lightbox" ddata-title="<?php echo esc_html($PHTtitle); ?>"><i class="icon-magnifying-glass"></i></a>
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
                </div>';
    }
?>
                <!-- bxslider init -->
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        jQuery('.bxslider').bxSlider({
                            adaptiveHeight: true,
                            mode: 'fade',
                            slideMargin: 0,
                            pager: false,
                            controls: true
                        });
                    });
                </script>

            </div>
        </div>
</div>
    <?php endwhile; ?>

    <?php else: ?>

        <div class="container general-font-area marg50">
            <h1 style="display: block; text-align: center;"><?php _e( 'Sorry, nothing to display.', THEME_SLUG ); ?></h1>
        </div>

    <?php endif; ?>

<?php get_footer(); ?>
