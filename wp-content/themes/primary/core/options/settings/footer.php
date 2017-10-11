<?php

$this->sections[] = array(
    'title'     => __('Footer', THEME_SLUG),
    'icon'      => 'el-icon-minus',
    'fields'    => array(

        array(
            'id'        => 'use_footer',
            'type'      => 'button_set',
            'title'     => __('Use Footer?', THEME_SLUG),
            'subtitle'  => __('You can turn off footer, if you need.', THEME_SLUG),
            'options'   => array(
                1       => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 1
        ),

        array(
            'id'        => 'footer_layout',
            'type'      => 'button_set',
            'title'     => __('Footer Layout', THEME_SLUG),
            'subtitle'  => __('You can choose how many columns you want in footer.', THEME_SLUG),
            'options'   => array(
                3 => '3 Columns',
                4 => "4 Columns"
            ),
            'required' => array('use_footer','equals', 1),
            'default'   => 4
        ),

        array(
            'id'        => 'rss',
            'type'      => 'text',
            'validate'  => 'url',
            'title'     => __('RSS Feed URL', THEME_SLUG),
            'desc'  => __("If you don't want to show RSS icon, live this field blank.", THEME_SLUG),
            'default'   => $this->getRSS()
        ),

        array(
            'id'        => 'footer_social',
            'type'      => 'button_set',
            'title'     => __('Footer Social Icons', THEME_SLUG),
            'subtitle'  => __('Enable/Disable social icons in header.', THEME_SLUG),
            'options' => array(
                1  => '&nbsp;I&nbsp;',
                0  => 'O'
            ),
            'default'   => 1
        ),


            array(
                'id'        => 'facebook',
                'type'      => 'text',
                'validate'  => 'url',
                'required'  => array('footer_social', '=', 1),
                'title'     => __('Facebook URL', THEME_SLUG),
                'default'   => 'http://facebook.com/'
            ),

            array(
                'id'        => 'twitter',
                'type'      => 'text',
                'validate'  => 'url',
                'required'  => array('footer_social', '=', 1),
                'title'     => __('Twitter URL', THEME_SLUG),
                'default'   => 'http://twitter.com/'
            ),

            array(
                'id'        => 'linkedin',
                'type'      => 'text',
                'validate'  => 'url',
                'required'  => array('footer_social', '=', 1),
                'title'     => __('Linkedin URL', THEME_SLUG),
                'default'   => 'http://linkedin.com/'
            ),

            array(
                'id'        => 'googleplus',
                'type'      => 'text',
                'validate'  => 'url',
                'required'  => array('footer_social', '=', 1),
                'title'     => __('Google Plus URL', THEME_SLUG),
                'default'   => 'http://plus.google.com/'
            ),

            array(
                'id'        => 'dribbble',
                'type'      => 'text',
                'validate'  => 'url',
                'required'  => array('footer_social', '=', 1),
                'title'     => __('Dribbble URL', THEME_SLUG),
                'default'   => 'http://dribbble.com'
            ),

        array(
            'id'        => 'copyright_text',
            'type'      => 'editor',
            'title'     => __('Copytight Text', THEME_SLUG),
            'subtitle'  => __('Place here your copyright. HTML tags are allowed.', THEME_SLUG),
            'default'   => 'Copyright &copy; 2017 Primary. Coded by <a href="http://themeforest.net/user/PhoenixTeam" target="_blank">PhoenixTeam</a>',
        )

    )
);
