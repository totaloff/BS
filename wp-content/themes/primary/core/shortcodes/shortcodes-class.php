<?php

new PhoenixTeam_Shortcodes();

class PhoenixTeam_Shortcodes extends WPBakeryShortCode {

    public function __construct ()
    {
        add_shortcode( THEME_SLUG . '_promo_title', array($this, 'promo_title') );
        add_shortcode( THEME_SLUG . '_portfolio_grid', array($this, 'portfolio_grid') );
        add_shortcode( THEME_SLUG . '_service', array($this, 'service') );
        add_shortcode( THEME_SLUG . '_team', array($this, 'team_member') );
        add_shortcode( THEME_SLUG . '_get_in_touch', array($this, 'widget_get_in_touch') );
        add_shortcode( THEME_SLUG . '_postbox', array($this, 'post_box') );
        add_shortcode( THEME_SLUG . '_testimonials', array($this, 'testimonials') );
        add_shortcode( THEME_SLUG . '_clients', array($this, 'clients_slider') );
        add_shortcode( THEME_SLUG . '_facts', array($this, 'facts') );
    }


    public function facts ($attrs, $content = null)
    {
        extract( shortcode_atts(array(
            "icon"       => null,
            "data"       => null,
            "name"       => null,
            "css"        => null,
            "link"       => null,
            "link_place" => null,
            "target"     => null
        ), $attrs) );

        $vcCssClass = null;
        if (function_exists('vc_shortcode_custom_css_class'))
            $vcCssClass = vc_shortcode_custom_css_class( $css, ' ' );

        if ($icon)
            $icon = '<div class="fact-icon"><i class="'. esc_attr($icon) .'"></i></div>';

        if ($data)
            $data = '<div class="fact-numb">'. esc_html($data) .'</div>';

        if ($name)
            $name = '<div class="fact-name">'. esc_html($name) .'</div>';

        if ($target)
            $target = ' target="_blank"';

        if ($link) {
            $link = '<a class="phoenixteam-facts-link" href="'. esc_url($link) .'"'. esc_attr($target) .'>';

            if ($link_place == "icon") {
                $return =
                '<div class="phoenixteam-shortcode-facts'. esc_attr($vcCssClass) .'">' .
                    $link .
                    $icon .
                    '</a>' .
                    $data .
                    $name .
                '</div>';
            } elseif ($link_place == 'data') {
                $return =
                '<div class="phoenixteam-shortcode-facts'. esc_attr($vcCssClass) .'">' .
                    $icon .
                    $link .
                    $data .
                    '</a>' .
                    $name .
                '</div>';
            } elseif ($link_place == 'text') {
                $return =
                '<div class="phoenixteam-shortcode-facts'. esc_attr($vcCssClass) .'">' .
                    $icon .
                    $data .
                    $link .
                    $name .
                    '</a>' .
                '</div>';
            }

        } else {
            $return =
            '<div class="phoenixteam-shortcode-facts'. esc_attr($vcCssClass) .'">' .
                $icon .
                $data .
                $name .
            '</div>';
        }

        return $return;
    }


    public function post_box ($attrs, $content = null)
    {
        extract( shortcode_atts(array(
            "qty" => 3,
            "css" => null,
            "cat" => null
        ), $attrs) );

        $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

        if ($qty) {
            $postsbox = array(
                "post_type" => "post",
                "post_status" => array("publish", "private"),
                "posts_per_page" => $qty,
                "paged" => false
            );

            if ($cat && $cat != "cat == false")
                $postsbox['category_name'] = $cat;

            $return = '<div class="phoenixteam-shortcode-posts-box">';
            $el_class = 'blog-main';

            $postsbox = new WP_Query($postsbox);

            if (!isset($postsbox->post))
                return false;

            if ($postsbox->have_posts()) {
                while($postsbox->have_posts()) {
                    $postsbox->the_post();

                    $ID = get_the_ID();
                    $title = get_the_title();

                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full', false );
                    $image = $image[0];
                    $link = get_permalink($ID);

                    $auth = get_post_field( 'post_author', $ID);

                    $author = get_the_author_meta( 'display_name', $auth );
                    $author_link = get_author_posts_url( $auth );

                    $cat = wp_get_post_categories( $ID );

                    if (is_array($cat) && count($cat) > 0) {
                        $cat = $cat[0];
                        $cat = get_category($cat);
                        $cat = __('in', THEME_SLUG) . ' <a href="'.esc_url(get_category_link($cat->cat_ID)).'">'.esc_html($cat->name).'</a>';
                    }

                    $format = get_post_format($ID);
                    if (!$format) $format = 'standard';

                    switch ($format) {
                        case 'standard': $format = 'icon-pencil'; break;
                        case 'image': $format = 'icon-camera'; break;
                        case 'video': $format = 'icon-video'; break;
                        case 'link': $format = 'icon-attachment'; break;
                        case 'quote': $format = 'icon-chat'; break;
                        case 'gallery': $format = 'icon-pictures'; break;
                        case 'audio': $format = 'icon-mic'; break;
                        default: $format = 'icon-pencil'; break;
                    }

                    $return .= '
                        <div class="'. esc_attr($el_class . $vcCssClass) .'">
                            <div class="blog-images">
                                <div class="post-thumbnail">
                                    <div class="single-item"></div>
                                    <div class="single-action">
                                        <span><a href="'.$link.'"><i class="'.esc_attr($format).'"></i></a></span>
                                    </div>
                                     <img data-no-retina="1" src="'.esc_url($image).'" alt="'.esc_attr($title).'">
                                </div>
                            </div>
                            <div class="blog-name"><a href="'.esc_url($link).'">'.esc_html($title).'</a></div>
                            <div class="blog-desc">' .
                                get_the_time('j F, Y ') .
                                __('by', THEME_SLUG) . ' <a href="'.esc_url($author_link).'">'.esc_html($author).'</a>, ' .
                                $cat .
                            '</div>
                        </div>';
                }
            }

            wp_reset_postdata();

            $return .= "</div>";

            return $return;
        }

        return false;
    }




 public function testimonials ($attrs, $content = null)
    {
        $return = null;

        extract( shortcode_atts(array(
            'id' => null,
            'css' => null,
            'title' => null,

        ), $attrs) );

        if ($id) {
            $testimonials = array(
                "post_type" => THEME_SLUG . '_testimonials',
                "post_status" => "publish",
                "p" => $id
            );

            $testimonials = new WP_Query($testimonials);
            wp_reset_postdata();

            $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

            $text = rwmb_meta(THEME_SLUG . '_testimonials_text', null, $id);
            $pic = rwmb_meta(THEME_SLUG . '_testimonials_author_pic', array('type' => 'image', 'size' => 'thumbnail'), $id);
            $company = rwmb_meta(THEME_SLUG . '_testimonials_authors_company', null, $id);
            $rating = rwmb_meta(THEME_SLUG . '_testimonials_rating', null, $id);


            if (!isset($testimonials->post))
                return false;

            $testimonials = $testimonials->post;

            if (!$title)
                $title = $testimonials->post_title;

            if (is_array($pic) && count($pic) > 0) {
                $pic = array_shift($pic);
                $pic = $pic['url'];
            } else {
                $pic = null;
            }

            $return = '
            <div class="testimonials-block'. esc_attr($vcCssClass) .'">
                <div class="testimonials-photo"><img data-no-retina="1" src="'.esc_url($pic).'" alt=""></div>
                <div class="testimonials-text">
                    <div class="testimonials-name"><h4>'.esc_html($title).'</h4> - '.esc_html($company).'</div>
                    <div class="testimonials-desc"><p>'.wp_kses_post($text).'</p></div>
                </div>
            </div>';

            return $return;
        }

        return false;
    }


    public function team_member ($attrs, $content = null)
    {
        extract( shortcode_atts(array(
            'id' => null,
            'title' => null,
            'css' => null
        ), $attrs) );

        $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

        if ($id) {
            $member = array(
                "post_type" => THEME_SLUG . "_team",
                "post_status" => "publish",
                "p" => $id
            );

            $member = new WP_Query($member);
            wp_reset_postdata();

            if (!isset($member->post))
                return false;

            $member = $member->post;

            if (!$title)
                $title = $member->post_title;

            $pic = rwmb_meta(THEME_SLUG . '_team_member_pic', array('type' => 'image', 'size' => 'medium'), $id);
            if (is_array($pic) && count($pic)) {
                $pic = array_shift($pic);
                $pic = $pic['full_url'];
                $pic = '<img data-no-retina="1" src="'.$pic.'" alt="'.$title.'">';
            } else {
                $pic = '<img data-no-retina="1" src="'.THEME_URI . '/assets/images/nopicture.png" alt="'.$title.'">';
            }

            $about = rwmb_meta(THEME_SLUG . '_team_member_text', null, $id);
            $position = rwmb_meta(THEME_SLUG . '_team_member_position', null, $id);
            $email = rwmb_meta(THEME_SLUG . '_team_member_email', null, $id);

            if ($position)
                $position = '<div class="about-desc">'.$position.'</div>';

            if ($about)
                $about = '<div class="about-texts">'.$about.'</div>';

            $socials = PhoenixTeam_Utils::get_member_socials($id);

            $socials_html = null;
            $socials_before = null;
            $socials_after = null;

            if ($socials) {
                $count = count($socials);

                for ($i=0; $i < $count; $i++) {
                    if ($socials[$i]['url']) {
                        $socials_html .= '<li><a href="'.esc_url($socials[$i]['url']).'" title="'.esc_attr($title).' '.esc_attr($socials[$i]['name']).' '.__("profile", THEME_SLUG).'"><i class="icon-'.esc_attr($socials[$i]['icon']).'"></i></a></li>';
                    }
                }
            }

            if ($email) {
                $socials_html .= '<li><a href="mailto:'. antispambot($email) .'"><i class="fa fa-envelope"></i></a></li>';
            }

            if ($socials_html) {
                $socials_before = '<ul class="soc-about">';
                $socials_after = '</ul>';
            }

            $return = '
                <div class="phoenixteam-shortcode-about-us about-us'. esc_attr($vcCssClass) .'">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-ms-12">' .
                            $pic .
                        '</div>' .
                        '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-ms-12">'.
                            '<div class="team-block"><div class="about-name">'.$title.'</div>' .
                            $position .
                            $about .
                            $socials_before .
                            $socials_html .
                            $socials_after .
                        '</div></div>
                    </div>
                </div>';

            return $return;
        }

        return false;

    }


    public function clients_slider ($attrs, $content = null)
    {
      extract( shortcode_atts(array(
        'images' => null,
        'popup' => false,
        'autoplay' => null,
        'nav' => null,
        'css' => null
      ), $attrs) );

      $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

      if ($images && count($images) > 0) {
          $images = explode( ',', $images );
      } else {
          return '<div class="phoenixteam-clients-carousel"><p>'. __("You didn't select any image.", THEME_SLUG) .'</p></div>';
      }

      $uID = 'jcarousel-shortcode-id-' . uniqid();
      $script = null;

      if ($autoplay) {
          $script =
          "<script>
            (function($) {
              'use strict';
              // Set autoscroll
              $(function() {
                setTimeout(function() {
                  var jcarousel = $('#". esc_js($uID) ."');
                  jcarousel.jcarouselAutoscroll({
                      target: '+=1'
                  });
                });
              }, 2000);
            })(jQuery);
          </script>";
      }

      $return =
      '<div class="phoenixteam-clients-carousel'. esc_attr($vcCssClass) .'">
      <div class="jcarousel-wrapper">
        <div class="jcarousel" id="'. esc_attr($uID) .'">
          <ul>';


      foreach ($images as $attach_id) {
          $thumb = wp_get_attachment_image_src( $attach_id, 'full', true );
          $thumb = $thumb[0];

          if ($popup) {
              $return .= '<li><a class="phoenixteam-image-link" href="'.esc_url($thumb).'"><img data-no-retina="1" src="'.esc_url($thumb).'" alt=""></a></li>';
          } else {
              $return .= '<li><img data-no-retina="1" src="'.esc_url($thumb).'" alt=""></li>';
          }
          // $return .= '<li><a class="phoenixteam-image-link" href="'.$thumb.'"><img data-no-retina="1" src="'.bfi_thumb( $thumb, array("width" => 170, "height" => 100, "crop" => true) ).'" alt=""></a></li>';
      }

      $return .= '</ul></div>';

      if ($nav !== 'yes') {
        $return .=
          '<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
           <a href="#" class="jcarousel-control-next">&rsaquo;</a>';
      }

      $return .= '</div></div>';
      $return .= $script;

      return $return;
    }


    public function service ($attrs, $content = null)
    {
        $return = null;
        $icon = null;
        $text = null;

        extract( shortcode_atts(array(
            'id' => null,
            'title' => null,
            'layout' => 'block',
            'css' => null,
            "link"  => null,
            "target" => null
        ), $attrs) );

        $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

        if ($id) {
            $service = array(
                "post_type" => THEME_SLUG . '_services',
                "post_status" => "publish",
                "p" => $id
            );

            $service = new WP_Query($service);
            wp_reset_postdata();

            if (!isset($service->post))
                return false;

            $service = $service->post;

            if (!$title)
                $title = $service->post_title;

            $icon = rwmb_meta(THEME_SLUG . '_services_icons_list', null, $id);
            $text = rwmb_meta(THEME_SLUG . '_services_text', null, $id);

            if ($target)
                $target = ' target="_blank"';

            if ($link) {
                $link = '<a class="phoenixteam-service-link" href="'. esc_url($link) .'"'. esc_attr($target) .'>';
                $link_closed = '</a>';
            } else {
                $link = $link_closed = null;
            }

            if ($layout == 'list') {
                $return = '
                    <div class="other-serv'. esc_attr($vcCssClass) .'">
                        <div class="serv-icon">'. $link .'<i class="fa '.esc_attr($icon).'"></i>'. $link_closed .'</div>
                        <div class="serv-block-list"><h2 class="serv-name">'.esc_html($title).'</h2><p class="serv-desc">'.$text.'</p></div>
                    </div>';
            } else {
                $return = '
                    <div class="hi-icon-effect'. esc_attr($vcCssClass) .'">' .
                        $link . '<div class="hi-icon fa '. esc_attr($icon) .'"></div>' . $link_closed .
                        '<div class="service-name">'.esc_html($title).'</div>
                        <div class="service-text">'.esc_html($text).'</div>
                    </div>';
            }

            return $return;
        }

        return false;
    }


    public function portfolio_grid ($attrs, $content = null)
    {
        $return = null;
        $icon = null;
        $text = null;

        extract( shortcode_atts(array(
            'qty' => 6,
            'css' => null
        ), $attrs) );

        wp_enqueue_script(THEME_SLUG . '-portfolio');

        $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

        $portfolio = array(
            'post_type' => THEME_SLUG . '_portfolio',
            'posts_per_page' => $qty,
            'post_status' => 'publish'
        );

        $portfolio = new WP_Query($portfolio);

        if ($portfolio->have_posts()) {
            $return = '<script>portSetts = {inlineError: "'.__("Error! Please refresh the page!", THEME_SLUG).'", moreLoading: "'.__("Loading...", THEME_SLUG).'", moreNoMore: "'.__("No More Works", THEME_SLUG).'"}; '.THEME_TEAM.'["queryVars"] = \''. serialize($portfolio->query_vars) .'\'; '.THEME_TEAM.'["currentPage"] = 1;</script> ' . "\n";

            $return .= '<div class="phoenix-shortcode-portfolio-grid'. esc_attr($vcCssClass) .'">
                <div class="cbp-l-grid-projects" id="grid-container-portfolio">
                    <ul>';

            while($portfolio->have_posts()) {
                $portfolio->the_post();

                $ID = get_the_id();

                $the_cat = get_the_terms( $ID , THEME_SLUG . '_portfolio_category');
                $categories = '';
                if (is_array($the_cat)) {
                    foreach($the_cat as $cur_term) {
                        $categories .= $cur_term->slug . ' ';
                    }
                }

                $thumb_params = array('width' => 555,'height' => 416, 'crop' => true);
                $thumb = null;

                $title = get_the_title();
                $author = rwmb_meta(THEME_SLUG . '_portfolio_author');
                $link = get_permalink();

                if (has_post_thumbnail()) {
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full', true );
                    $thumb = $thumb[0];
                } else {
                    $thumb = THEME_URI . "/assets/images/nopicture.png";
                }

                    $return .=
                    '<li class="cbp-item '.esc_attr($categories).'">
                            <div class="portfolio-phoenixteam"><div class="portfolio-image">';

                    if ($thumb) {
                        $return .= '<img data-no-retina="1" src="'. bfi_thumb( $thumb, $thumb_params ) .'" alt="'. esc_attr($title) .'" />
                    <figcaption>

                            <p class="icon-links">
                                <a href="'.esc_attr(site_url()) . '/wp-admin/admin-ajax.php?p='.esc_attr($ID). '" class="cbp-singlePageInline"><i class="icon-attachment"></i></a>
                                <a href="'.esc_url($thumb).'" class="cbp-lightbox" data-title="'.esc_attr($title).'"><i class="icon-magnifying-glass"></i></a>

                            </p>

                        </figcaption>
                        </div>';
                    }

                    $return .=
                    '
                        <h2>'.esc_html($title).'</h2>
                        <p>by '.esc_html($author).'</p>

                    </div>
        </li>';
            }
            $return .= '
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="button-center"><a href="#" class="btn-simple cbp-l-loadMore-button-link">Load Full Portfolio</a></div>
                </div>
            </div>';

            wp_reset_postdata();

            return $return;
        }

        return false;
    }


    public function promo_title ($attrs, $content = null)
    {
        extract( shortcode_atts(array(
            'title' => 'Title',
            'css' => null
        ), $attrs) );

        $cssClass = "phoenixteam-shortcode-promo-block";
        $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

        $result = '<div class="'. esc_attr($cssClass . $vcCssClass) .'">';
        $result .= '<div class="promo-block">';

        if ($title)
            $result .= '<div class="promo-text">'. esc_html($title) .'</div>';

        $result .= '<div class="center-line"></div>';

        $result .= '</div>';

        if ($content)
            $result .= '<div class="promo-paragraph">'. PhoenixTeam_Utils::unautop(esc_html($content)) .'</div>';

        $result .= '</div>';

        return $result;
    }


    public function widget_get_in_touch ( $attrs, $content = null )
    {
        $result = null;

        extract(shortcode_atts(array(
            'adress' => null,
            'phone' => null,
            'fax' => null,
            'skype' => null,
            'email' => null,
            'weekend' => null,
            'css' => null
        ), $attrs));

        $vcCssClass = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $attrs);

        $result = '<div class="'. THEME_SLUG .'-shortcode-contact'. esc_attr($vcCssClass) .'">';
        $type = 'PhoenixTeam_Widget_GetInTouch';
        $args = array();

        ob_start();
        the_widget($type, $attrs, $args);
        $result .= ob_get_clean();

        $result .= '</div>';

        return $result;
    }

}
