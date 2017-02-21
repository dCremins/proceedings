<?php

add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path($path)
{
    // update path
    $path = plugin_dir_path(dirname(__FILE__)) . '/acf/';

    // return
    return $path;
}

add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir($dir)
{
    // update path
    $dir = plugins_url('/../acf/', __FILE__);

    // return
    return $dir;
}

include_once(plugin_dir_path(dirname(__FILE__)) . 'acf/acf.php');
