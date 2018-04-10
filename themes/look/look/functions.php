<?php

//define
define('VERSION','1.0');
define('THEME_DIR',get_theme_root().'/look');
define('THEME_URI',get_theme_root_uri().'/look');

define('MAIN_ASSETS_URI',THEME_URI.'/assets');

global $wp_filesystem;
if (empty($wp_filesystem)) {
    require_once (ABSPATH . '/wp-admin/includes/file.php');
    WP_Filesystem();
}
//admin options
require_once THEME_DIR . '/modules/options/options-framework.php';
$view = (look_get_option('look_layout') == '') ? 'fix': look_get_option('look_layout');
define('VIEW',$view);
define('ASSETS_URI',THEME_URI.'/views/'.VIEW.'/assets');
require_once THEME_DIR . '/modules/import/init.php';

require_once THEME_DIR . '/modules/class-tgm-plugin-activation.php';
//helper
require_once THEME_DIR . '/includes/helper.php';

//add css , script
require_once THEME_DIR . '/includes/class-look-assets.php';

//color swatch
require_once THEME_DIR . '/includes/class-color-swatch.php';

//page title
require_once THEME_DIR . '/includes/class-page-title.php';

//menu
require_once THEME_DIR . '/includes/menu.php';

//sidebar
require_once THEME_DIR . '/includes/sidebar.php';

//widget
require_once THEME_DIR . '/includes/widget.php';

//woocommerce
require_once THEME_DIR . '/includes/woo_func.php';

//post format
require_once THEME_DIR . '/includes/look_setup.php';

//microdata markup
require_once THEME_DIR . '/includes/markup.php';

//theme function
if(file_exists(THEME_DIR.'/views/'.VIEW.'/functions.php'))
{
	require THEME_DIR .'/views/'.VIEW.'/functions.php';
}

//note need css functions
