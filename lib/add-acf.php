<?php

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path($path)
{
    // update path
    $path = plugin_dir_path(dirname(__FILE__)) . '/acf/';

    // return
    return $path;
}


// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir($dir)
{
    // update path
    $dir = plugins_url('/../acf/', __FILE__);

    // return
    return $dir;
}


// 3. Hide ACF field group menu item
// add_filter('acf/settings/show_admin', '__return_false');

/* Checks to see if "is_plugin_active" function exists and if not load the php file that includes that function */
if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

// 4. Include ACF
if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
    //include_once(dirname(__FILE__) . './../acf/acf.php');
    require_once(plugin_dir_path(dirname(__FILE__)) . 'acf/acf.php');
}
