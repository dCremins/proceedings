<?php
/*
Plugin Name: ICOET Proceedings
GitHub Plugin URI: https://github.com/dcremins/proceedings
GitHub Branch:      master
Description: Custom Proceeding Post Type and Views for ICOET website use
Version: 1.0.8
Author: Devin Cremins
Author URI: http://octopusoddments.com
*/

// Add all files in lib folder into array
$include = [
  '/lib/add-acf.php',           // Register ACF
  '/lib/cpt.php',               // Register Post Type
  '/lib/templates.php'         // Register Views
];

// Require Once each file in the array
foreach ($include as $file) {
    if (!$filepath = (dirname(__FILE__) .$file)) {
        trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
    }
    require_once $filepath;
}
unset($file, $filepath);

/* Add main.css */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('proceedings_css', plugins_url('/styles/main.css', __FILE__));
});


/* Script-tac-ulous -> tab scripts */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('tabs', plugins_url('/js/jquery.tabslet.min.js', __FILE__), array('jquery'), '1', true);
    wp_enqueue_script('tabs-init', plugins_url('/js/tab-init.js', __FILE__), array('tabs'), '1', true);
});
