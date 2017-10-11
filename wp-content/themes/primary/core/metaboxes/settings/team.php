<?php

$multisocials = isset($this->data['multisocials']) ? $this->data['multisocials'] : false;

$meta_boxes[THEME_SLUG . '_team'] = array(
    'id' => THEME_SLUG . '_team',
    'title' => __( 'Team Member Details', THEME_SLUG ),
    'pages' => array( THEME_SLUG . '_team' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,

    'fields' => array(
        array(
            'name'             => __( 'Picture:', THEME_SLUG ),
            'id'               => THEME_SLUG . "_team_member_pic",
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
        ),
// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_team_member_divider", // Not used, but needed
),
        // Abuut
        array(
            'name' => __( 'About:', THEME_SLUG ),
            'desc' => __( 'Some words about the member.', THEME_SLUG ),
            'id'   => THEME_SLUG . "_team_member_text",
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 6,
        ),
// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_team_member_divider1", // Not used, but needed
),
        // Company Position
        array(
            'name'  => __( 'Position:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_member_position",
            'desc' => __( 'Ex:', THEME_SLUG ) . '<a href="#" class="'. THEME_SLUG . '-demo-content"> ' . __('Web Developer', THEME_SLUG) .'</a> or <a href="#" class="'. THEME_SLUG . '-demo-content">'. __('Sales Manager', THEME_SLUG) .'</a>',
            'type'  => 'text',
        ),
        // Email Address
        array(
            'name'  => __( 'Email (optional):', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_member_email", // fa-envelope
            'desc'  => __( 'Email will be published with <b>antispambot</b> protection.', THEME_SLUG ),
            'type'  => 'text',
        ),
        // Social Networks
        array(
            'name' => __( 'Social Networks', THEME_SLUG ),
            'type' => 'heading',
            'id'   => 'fake_id', // Not used but needed for plugin
        ),
    )
);

if ($multisocials) {
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'name'  => __( 'Social Networks:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_socials_name",
            'desc'  => __( 'Select social network. Clone this field to choose another network.', THEME_SLUG ),
            'type'  => 'select_advanced',
            'multiple'    => false,
            'options'  => array(
                "Android" => "Android",
                "Apple" => "Apple",
                "Behance" => "Behance",
                "Bitbucket" => "Bitbucket",
                "Bitcoin" => "Bitcoin",
                "Btc" => "Btc",
                "Codepen" => "Codepen",
                "Css3" => "Css3",
                "Delicious" => "Delicious",
                "Deviantart" => "Deviantart",
                "Digg" => "Digg",
                "Dribbble" => "Dribbble",
                "Dropbox" => "Dropbox",
                "Drupal" => "Drupal",
                "Empire" => "Empire",
                "Facebook" => "Facebook",
                "Flickr" => "Flickr",
                "Foursquare" => "Foursquare",
                "Git" => "Git",
                "Github" => "Github",
                "Gittip" => "Gittip",
                "Google" => "Google",
                "Html5" => "Html5",
                "Instagram" => "Instagram",
                "Joomla" => "Joomla",
                "JsFiddle" => "JsFiddle",
                "LinkedIn" => "LinkedIn",
                "Linux" => "Linux",
                "maxCDN" => "maxCDN",
                "openID" => "openID",
                "PageLines" => "PageLines",
                "Pied" => "Pied",
                "Pinterest" => "Pinterest",
                "QQ" => "QQ",
                "Rebel" => "Rebel",
                "Reddit" => "Reddit",
                "Renren" => "Renren",
                "Skype" => "Skype",
                "Slack" => "Slack",
                "Soundcloud" => "Soundcloud",
                "Spotify" => "Spotify",
                "Steam" => "Steam",
                "Stumbleupon" => "Stumbleupon",
                "Trello" => "Trello",
                "Tumblr" => "Tumblr",
                "Twitter" => "Twitter",
                "Vine" => "Vine",
                "Vk" => "Vk",
                "Wechat" => "Wechat",
                "Weibo" => "Weibo",
                "Weixin" => "Weixin",
                "Windows" => "Windows",
                "WordPress" => "WordPress",
                "Xing" => "Xing",
                "Yahoo" => "Yahoo",
                "YouTube" => "YouTube",
                "Google +" => "Google +",
                "Hacker News" => "Hacker News",
                "Stack Exchange" => "Stack Exchange",
                "Stack Overflow" => "Stack Overflow",
            ),
            'placeholder' => __( 'Select Social Network', THEME_SLUG ),
            'clone' => true
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'type' => 'divider',
            'id'   => THEME_SLUG . "_team_member_divider4", // Not used, but needed
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'name'  => __( 'Social URLs:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_socials_url",
            'desc'  => __( 'Select URLs for your social networks defined above. Clone this field to choose another network.<br/>Note that the number and order of these fields must comply with social networks fields , defined above.', THEME_SLUG ),
            'type'  => 'url',
            'clone' => true
    );
} else {
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'name'  => __( 'Facebook URL:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_fb_url",
            'desc'  => __( 'Ex:', THEME_SLUG ) . ' <a href="#" class="'. THEME_SLUG . '-demo-content">'. 'https://www.facebook.com/matt.mullenweg</a>',
            'type'  => 'url'
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'type' => 'divider',
            'id'   => THEME_SLUG . "_team_member_divider4", // Not used, but needed
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'name'  => __( 'Twitter URL:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_twt_url",
            'desc'  => __( 'Ex:', THEME_SLUG ) . ' <a href="#" class="'. THEME_SLUG . '-demo-content">'. 'https://twitter.com/Ph0enixTeam</a>',
            'type'  => 'url'
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'type' => 'divider',
            'id'   => THEME_SLUG . "_team_member_divider5", // Not used, but needed
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'name'  => __( 'LinkedIn URL:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_linkedin_url",
            'desc'  => __( 'Ex:', THEME_SLUG ) . ' <a href="#" class="'. THEME_SLUG . '-demo-content">'. 'https://www.linkedin.com/pub/guido-van-rossum/0/756/4a0</a>',
            'type'  => 'url',
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'type' => 'divider',
            'id'   => THEME_SLUG . "_team_member_divider6", // Not used, but needed
    );
    $meta_boxes[THEME_SLUG . '_team']['fields'][] =
        array(
            'name'  => __( 'Google+ URL:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_team_gplus_url",
            'desc'  => __( 'Ex:', THEME_SLUG ) . ' <a href="#" class="'. THEME_SLUG . '-demo-content">'. 'https://plus.google.com/+LinusTorvalds/posts</a>',
            'type'  => 'url'
    );
}