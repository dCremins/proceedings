<?php
/*
Plugin Name: ICOET Proceedings
GitHub Plugin URI: https://github.com/dcremins/proceedings
GitHub Branch:      master
Description: Custom Post Type and Views for ICOET website use
Version: 0.1
Author: Devin Cremins
Author URI: http://octopusoddments.com
*/

// Add all files in lib folder into array
$include = [
  '/lib/cpt.php',         // Register Post Type
  '/lib/templates.php'    // Register Views
];

// Require Once each file in the array
foreach ($include as $file) {
  if (!$filepath = (dirname( __FILE__ ) .$file)) {
    trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

/* Add main.css */
add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style( 'proceedings_css', plugins_url( '/styles/main.css', __FILE__ ) );
});


?>
