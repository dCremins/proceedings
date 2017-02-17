<?php
function proceedings_author_shortcode( ) {
    if ( function_exists( 'coauthors_posts_links' ) ) {
        $author = coauthors_posts_links( null, null, null, null, false );
    } else {
        $author = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span>';
    }
    return $author;
}
 ?>
