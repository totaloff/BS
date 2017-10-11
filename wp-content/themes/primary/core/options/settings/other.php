<?php

$this->sections[] = array(
    'title'     => __('Other', THEME_SLUG),
    'icon'      => ' el-icon-puzzle',
    'fields'    => array(

        array(
            'id'        => 'show_adminbar',
            'type'      => 'button_set',
            'title'     => __('Show WordPress Admin Bar?', THEME_SLUG),
            'subtitle'  => __('You can disable it for <i><b>all users</b></i> here.', THEME_SLUG),
            'options'   => array(
                1       => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 1
        ),

        array(
            'id'        => 'multisocials',
            'type'      => 'button_set',
            'title'     => __('Use Multisocial Buttons?', THEME_SLUG),
            'subtitle'  => __('Use multisocial (dynamically defined) or predifined social buttons for Team Members', THEME_SLUG),
            'options' => array(
                1  => '&nbsp;I&nbsp;',
                0  => 'O'
            ),
            'default'   => 1
        ),

        array(
            'id'        => 'analytics_switch',
            'type'      => 'button_set',
            'title'     => __('Enable Google Analytics?', THEME_SLUG),
            'subtitle'  => __('Enables/Disables GA Tracking Code for your website.', THEME_SLUG),
            'options'   => array(
                1        => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default' => 0
        ),

            array(
                'id'        => 'ga_id',
                'type'      => 'text',
                'required'  => array('analytics_switch', '=', '1'),
                'title'     => __('Google Analytics Property ID', THEME_SLUG),
                'desc'  => __('Place here your Google Analytics Property ID. It should look like `UA-XXXXX-X`.<br />You can find it inside your Google Analytics Dashboard.', THEME_SLUG),
                'default'   => null
            ),


        array(
            'id'        => 'css_code',
            'type'      => 'ace_editor',
            'title'     => __('Custom CSS', THEME_SLUG),
            'subtitle'  => __('Paste your CSS code her.', THEME_SLUG),
            'mode'      => 'css',
            'validate'  => 'css',
            'theme'     => 'chrome',
            'desc'      => 'CSS will be enqueued in header.',
            'default'   => ''
        ),

        array(
            'id'        => 'js_code',
            'type'      => 'ace_editor',
            'title'     => __('Custom JavaScript', THEME_SLUG),
            'subtitle'  => __('Paste your JavaScript code here.', THEME_SLUG),
            'mode'      => 'javascript',
            // 'validate'  => 'js',
            'theme'     => 'chrome',
            'desc'      => 'JS code will be enqueued before &lt/body&gt; tag.',
            'default'   => ''
        ),

        array(
            'id'        => 'enable_import_export',
            'type'      => 'button_set',
            'title'     => __('Enable Import/Export?', THEME_SLUG),
            'subtitle'  => __('Enables/Disables the ability to import/export configuration of theme options.', THEME_SLUG),
            'options'   => array(
                1        => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default' => 0
        ),
    ),
);
