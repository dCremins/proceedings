<?php
/* Search Theme for CPT templates and then use the templates in this Plugin if none are found */

add_filter( 'template_include', 'include_template_function', 1 );


function include_template_function( $template_path ) {
    if ( get_post_type() == 'proceedings' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-proceedings.php' ) ) ) {
                return $theme_file;
            }
                return dirname( __FILE__ ) . '/single-proceedings.php';

        } else {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-proceedings.php' ) ) ) {
                return $theme_file;
            }
                return dirname( __FILE__ ) . '/archive-proceedings.php';

        }
    }
    return $template_path;
}

 ?>
