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
			      	<div class="page-in-name">
<?php
			      		echo "<h1>";
                    the_title();

                if ($PHTpage_subtitle)
                  echo ': <span>'. esc_html( $PHTpage_subtitle ) .'</span>';

                echo "</h1>";
?>
			      	</div>
			      </div>
<?php
				if ($PHTgen_crumbs && !$PHTpage_crumbs || $PHTgen_crumbs && $PHTpage_crumbs === '-1') :

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

			<section id="page-<?php the_ID(); ?>" <?php post_class('marg50 container general-font-area phoenixteam-sidebar-'. $PHTsidebar_pos); ?>>
				<div class="row">
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
                        <?php dynamic_sidebar($PHTsidebar_area); ?>
                    </div><!-- sidebar end-->

                    <div class="col-lg-9">
<?php
                }

				the_content();

				if ($PHTsidebar_pos == 'right') : ?>
						</div>
						<!-- sidebar -->
						<div class="col-lg-3">
							<?php dynamic_sidebar($PHTsidebar_area); ?>
						</div><!-- sidebar end-->
					</div>
				<?php elseif ($PHTsidebar_pos == 'left') : ?>
					</div>
				<?php endif; ?>

				<?php if ($PHTcomments) : ?>
					<div class="cl-blog-line"></div>
					<!-- comments -->
					<div class="container">
						<?php comments_template('', 'true'); ?>
					</div>
					<!-- /comments -->
				<?php endif; ?>
			</div>
			</section>
<?php
		}
	}
?>

<?php get_footer(); ?>
