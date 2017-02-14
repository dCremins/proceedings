<?php

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path($path)
{
    // update path
    $path = dirname(__FILE__) . '/../acf/';

    // return
    return $path;
}


// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir($dir)
{
    // update path
    $dir = dirname(__FILE__) . '/../acf/';

    // return
    return $dir;
}


// 3. Hide ACF field group menu item
// add_filter('acf/settings/show_admin', '__return_false');


// 4. Include ACF
include_once(dirname(__FILE__) . '/../acf/acf.php');
