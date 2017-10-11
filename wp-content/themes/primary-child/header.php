<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
        <title><?php wp_title(); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"/>
        <meta content="<?php bloginfo('description'); ?>" name="description">
        <?php echo PhoenixTeam_Utils::favicons(); ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

    <div class="wrapper<?php echo PhoenixTeam_Utils::template_layout(); ?>">
        <div class="page_head">
            <div class="row top-header">
                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-12 pull-right">
                    <div class="top-menu">
                        <?php PhoenixTeam_Utils::create_nav('top-menu', 1, 'top_menu'); ?>
                    </div>
                </div>
            </div>      
            <div id="nav-container" class="nav-container<?php echo PhoenixTeam_Utils::menu_layout(); ?>" style="height: auto;">
                 <nav role="navigation">                
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 pull-left">
                                <div class="logo">
                                    <?php echo PhoenixTeam_Utils::show_logo(); ?>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-6 pull-right">
                                <div class="menu phoenixteam-menu-wrapper">
                                    <?php if (PhoenixTeam_Utils::dep_exists('megamenu')) : ?>
                                        <?php PhoenixTeam_Utils::create_nav('header-menu'); ?>
                                    <?php else : ?>
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"></button>
                                        <div class="navbar-collapse collapse">
                                            <?php PhoenixTeam_Utils::create_nav('header-menu'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
