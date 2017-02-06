<?php
/*
Plugin Name: ICOET Proceedings
GitHub Plugin URI: https://github.com/dcremins/proceedings
GitHub Branch:      master
Description: Custom Post Type and Views for ICOET website use
Version: 0.2
Author: Devin Cremins
Author URI: http://octopusoddments.com
*/

// Add all files in lib folder into array
$include = [
  '/app/lib/cpt.php',               // Register Post Type
  '/app/lib/acf.php',               // Register Fields
  '/app/lib/templates.php',         // Register Views
  '/app/lib/author-filter.php'      // Alter Co-Author List Display
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
	wp_enqueue_style( 'proceedings_css', plugins_url( '/app/styles/main.css', __FILE__ ) );
});


/* Script-tac-ulous -> tab scripts */
add_action( 'wp_enqueue_scripts', function() {
 wp_enqueue_script( 'tabs' , plugins_url( '/app/js/jquery.tabslet.min.js', __FILE__ ) , array( 'jquery' ), '1', true );
 wp_enqueue_script( 'tabs-init' , plugins_url( '/app/js/tab-init.js', __FILE__ ), array( 'tabs' ), '1', true );
});

?>
