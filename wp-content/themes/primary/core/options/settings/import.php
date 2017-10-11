<?php

$section = get_option($this->args['opt_name']);

$section = isset($section['enable_import_export']) ? $section['enable_import_export'] : false;

if ($section) {
    $this->sections[] = array(
        'title'     => __('Import / Export', THEME_SLUG),
        'icon'      => 'el-icon-download-alt',
        'fields'    => array(

            array(
                    'id'            => 'theme_import_export',
                    'type'          => 'import_export',
                    'title'      => __('Save and restore theme options.', THEME_SLUG),
                    'full_width'    => true,
            )

        )
    );
}
