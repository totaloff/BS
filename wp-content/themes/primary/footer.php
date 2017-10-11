<?php
  global $PhoenixData;
  $PHTcopyright = isset($PhoenixData['copyright_text']) ? $PhoenixData['copyright_text'] : null;
  $PHTlayout = isset($PhoenixData['footer_layout']) ? $PhoenixData['footer_layout'] : 3;
  $PHTuse_footer = isset($PhoenixData['use_footer']) ? $PhoenixData['use_footer'] : 1;
  $PHTuse_footer = ($PHTuse_footer) ? ' footer-bottom-top-section-present' : null;
?>

<!-- footer -->
<div class="footer general-font-area<?php echo sanitize_html_class($PHTuse_footer); ?>">

<?php if ($PHTuse_footer) : ?>

  <?php echo PhoenixTeam_Utils::footer_socials(); ?>

  <div class="container">
    <div class="row">
      <?php if ($PHTlayout == 4) : ?>
        <div class="col-lg-3 col-md-3 col-sm-3">
<?php
        if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-1') ) {
          dynamic_sidebar('footer-1');
        } else {
          echo '
          <div class="widget_text footer-widget">
            <h4 class="widget-title">Footer Sidebar 1</h4>
            <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 1" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
          </div>';
        }
?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
<?php
        if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-1') ) {
          dynamic_sidebar('footer-2');
        } else {
          echo
          '<div class="widget_text footer-widget">
            <h4 class="widget-title">Footer Sidebar 2</h4>
            <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 2" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
          </div>';
        }
?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
<?php
        if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-3') ) {
          dynamic_sidebar('footer-3');
        } else {
          echo '
          <div class="widget_text footer-widget">
            <h4 class="widget-title">Footer Sidebar 3</h4>
            <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 3" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
          </div>';
        }
?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
<?php
          if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-4') ) {
              dynamic_sidebar('footer-4');
          } else {
            echo '
            <div class="widget_text footer-widget">
              <h4 class="widget-title">Footer Sidebar 4</h4>
              <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 4" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
            </div>';
          }
?>
        </div>

      <?php else : ?>

        <div class="col-lg-4 col-md-4 col-sm-4">
<?php
          if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-1') ) {
            dynamic_sidebar('footer-1');
          } else {
            echo '
            <div class="widget_text footer-widget">
              <h4 class="widget-title">Footer Sidebar 1</h4>
              <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 1" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
            </div>';
          }
?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
<?php
          if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-2') ) {
            dynamic_sidebar('footer-2');
          } else {
            echo '
            <div class="widget_text footer-widget">
              <h4 class="widget-title">Footer Sidebar 2</h4>
              <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 2" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
            </div>';
          }
?>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
<?php
            if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-3') ) {
              dynamic_sidebar('footer-3');
            } else {
              echo '
              <div class="widget_text footer-widget">
                <h4 class="widget-title">Footer Sidebar 3</h4>
                <div class="textwidget">' . __('Drop a widget on "Footer Sidebar 3" sidebar at Appearance > Widgets page.', THEME_SLUG) . '</div>
              </div>';
            }
?>
          </div>
      <?php endif; ?>
    </div>
  </div>

<?php endif; ?>

  <div class="container">
    <div class="footer-bottom">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-ms-12 pull-left">
          <div class="copyright">
            <?php if ($PHTcopyright) echo wp_kses_post( $PHTcopyright ); ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-ms-12 pull-right">
          <div class="foot_menu">
              <?php PhoenixTeam_Utils::create_nav('footer-menu', 1, 'foot_menu'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /wrapper -->

<?php wp_footer(); ?>

  </body>
</html>
