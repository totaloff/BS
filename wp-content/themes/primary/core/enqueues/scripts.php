<?php

new PhoenixTeam_Scripts();

class PhoenixTeam_Scripts {

    private $gaID;
    private $jsCODE;

    public function __construct ()
    {
        global $PhoenixData;

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts')); // Add Custom Scripts to wp_head
        add_action('wp_enqueue_scripts', array($this, 'conditional_scripts')); // Add Conditional Page Scripts

        $analytics = isset($PhoenixData['analytics_switch']) ? $PhoenixData['analytics_switch'] : false;
        $this->gaID = isset($PhoenixData['ga_id']) ? $PhoenixData['ga_id'] : null;
        $this->jsCODE = isset($PhoenixData['js_code']) ? $PhoenixData['js_code'] : false;

        if ($analytics && $this->gaID) {
            add_action('wp_footer', array($this, 'ga'), 99);
        }

        // Add Custom JS
        if ($this->jsCODE) {
            add_action('wp_footer', array($this, 'custom_js'), 99);
        }
    }

    // Load Custom JS
    public function custom_js ()
    {
        echo '<script type="text/javascript" id="'. THEME_SLUG .'-custom-js">' . $this->jsCODE . '</script>' . "\n";
    }

    // Load Google Analytics
    public function ga ()
    {
        echo "
        <script type='text/javascript' id='". THEME_SLUG . "-google-analytics'>
            var _gaq = _gaq || []; _gaq.push(['_setAccount', '". esc_js($this->gaID) ."']); _gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();
        </script>\n";
    }

    // Load theme scripts
    public function enqueue_scripts ()
    {
        global $PhoenixData, $template;

        $show_sticky_menu = isset($PhoenixData['use_sticky']) ? $PhoenixData['use_sticky'] : true;
        $port_layout = isset($PhoenixData['port_layout']) ? $PhoenixData['port_layout'] : '2-cols';

        switch ($port_layout) {
            case '2-cols': $cube_js = 'portfolio-2'; break;
            case '3-cols': $cube_js = 'portfolio-3'; break;
            case '4-cols': $cube_js = 'portfolio-4'; break;
            case 'full': $cube_js = 'portfolio-fullwidth'; break;
            default: $cube_js = 'portfolio-2'; break;
        }

        if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
            // In Header
            wp_register_script(THEME_SLUG . '-modernizr', THEME_URI . '/assets/js/modernizr.custom.js', array('jquery'), '1.0.0');

            // In Footer
            wp_register_script(THEME_SLUG . '-sticky', THEME_URI . '/assets/js/sticky.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-bootstrap', THEME_URI . '/assets/js/bootstrap.min.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-bxslider', THEME_URI . '/assets/js/jquery.bxslider.min.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-retina', THEME_URI . '/assets/js/retina.min.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-jquery-cycle', THEME_URI . '/assets/js/jquery.cycle.all.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-jquery-parallax', THEME_URI . '/assets/js/jquery.parallax-1.1.3.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-jquery.cubeportfolio', THEME_URI . '/assets/js/jquery.cubeportfolio.min.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-portfolio', THEME_URI . '/assets/js/'. $cube_js .'.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-jcarousel-responsive', THEME_URI . '/assets/js/jcarousel.responsive.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-jquery-jcarousel', THEME_URI . '/assets/js/jquery.jcarousel.min.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-magnific-popup', THEME_URI . '/assets/js/magnific.popup.min.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-testimonialrotator', THEME_URI . '/assets/js/testimonialrotator.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-contact-form', THEME_URI . '/assets/js/contacts.js', array('jquery'), '1.0.0', true);
            wp_register_script(THEME_SLUG . '-main', THEME_URI . '/assets/js/main.js', array('jquery'), '1.0.0', true);

            // Localize scripts
            wp_localize_script('jquery', THEME_TEAM, PhoenixTeam_Utils::javascript_globals());

            // Enqueue scripts
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-migrate');
            wp_enqueue_script(THEME_SLUG . '-modernizr');

            if ($show_sticky_menu) {
                wp_enqueue_script(THEME_SLUG . '-sticky');
            }

            wp_enqueue_script(THEME_SLUG . '-bootstrap');
            wp_enqueue_script(THEME_SLUG . '-bxslider');
            wp_enqueue_script(THEME_SLUG . '-retina');
            wp_enqueue_script(THEME_SLUG . '-jquery-cycle');
            wp_enqueue_script(THEME_SLUG . '-jquery-parallax');
            wp_enqueue_script(THEME_SLUG . '-jquery.cubeportfolio');

            $what_template = get_page_template_slug();
            if ($what_template == 'template-portfolio.php' || basename($template) == 'single-' . THEME_SLUG . '_portfolio.php') {
                $cubeportfolio = array(
                    'inlineError' => __("Error! Please refresh the page!", THEME_SLUG),
                    'moreLoading' => __("Loading...", THEME_SLUG),
                    'moreNoMore' => __("No More Works", THEME_SLUG)
                );
                wp_localize_script(THEME_SLUG . '-jquery.cubeportfolio', 'portSetts', $cubeportfolio);
                wp_enqueue_script(THEME_SLUG . '-portfolio');
            }

            wp_enqueue_script(THEME_SLUG . '-jcarousel-responsive');
            wp_enqueue_script(THEME_SLUG . '-jquery-jcarousel');
            wp_enqueue_script(THEME_SLUG . '-magnific-popup');
            wp_enqueue_script(THEME_SLUG . '-testimonialrotator');
            wp_enqueue_script(THEME_SLUG . '-main');
        }
    }

    // Load conditional scripts
    public function conditional_scripts ()
    {
        if ( is_singular(THEME_SLUG . '_portfolio') ) {
            wp_dequeue_script(THEME_SLUG . '-portfolio');
            wp_register_script(THEME_SLUG . '-portfolio-single', THEME_URI . '/assets/js/portfolio-3.js', array('jquery'), '1.0.0', true);
            wp_enqueue_script(THEME_SLUG . '-portfolio-single');
        }
    }

}
