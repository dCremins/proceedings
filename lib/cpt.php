<?php
function proceedings_post_type() {
  register_post_type('proceedings', [
    'labels'        => [
      'name'                => __('Proceedings'),
      'singular_name'       => __('Proceeding'),
      'add_new'             => __('Add New'),
      'add_new_item'        => __('Add New Proceeding'),
      'new_item'            => __('New Proceedings'),
      'edit_item'           => __('Edit Proceedings'),
      'view_item'           => __('View Proceedings'),
      'all_items'           => __('All Proceedings'),
      'search_items'        => __('Search Proceedings'),
      'parent_item_colon'   => __('Parent Proceedings'),
      'not_found'           => __('No Proceedings found.'),
      'not_found_in_trash'  => __('No Proceedings found in Trash.'),
    ],
    'public'        => true,
    'query_var'     => true,
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-media-document',
    'supports'      => array('title', 'editor', 'author'),

  ]);
}

add_action('init', 'proceedings_post_type');
?>
