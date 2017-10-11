<?php

$this->sections[] = array(
    'icon'      => 'el-icon-credit-card',
    'title'     => __('Sidebars', THEME_SLUG),
    'fields'    => array(

        array(
            'id'=>'sidebars_list',
            'type' => 'multi_text',
            'title' => __('Sidebars Generator', THEME_SLUG),
            'validate' => 'no_special_chars',
            'add_text' => __('Add Sidebar', THEME_SLUG),
            'subtitle' => __('Add unlimited custom sidebars to you site.', THEME_SLUG),
            'default'  => null
        )

    ),
);