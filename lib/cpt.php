<?php

namespace Proceedings\CPT;

function proceedings_post_type()
{
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

add_action('init', __NAMESPACE__ . '\\proceedings_post_type');

add_action('pre_get_posts', __NAMESPACE__ . '\\include_proceedings_in_query', 99);

function include_proceedings_in_query($query) {
    if(is_author() && $query->is_main_query()) {              // Ensure you only alter your desired query
        $post_types = $query->get('post_type');               // Get the currnet post types in the query
        $new_types = [];
        if(!is_array($post_types) && !empty($post_types)) {   // Check that the current posts types are
          $new_types[] = $post_types;                         // stored as an array
        }
        if (!in_array('proceedings', $new_types)) {
          $new_types[] = 'proceedings';                       // Add your custom post type
        }
        $query->set('post_type', $new_types);                 // Add the updated list of post types to your query
    }
    return $query;
}



function sessions_post_type()
{
    register_post_type('session', [
    'labels'        => [
      'name'                => __('Sessions'),
      'singular_name'       => __('Session'),
      'add_new'             => __('Add New'),
      'add_new_item'        => __('Add New Session'),
      'new_item'            => __('New Sessions'),
      'edit_item'           => __('Edit Sessions'),
      'view_item'           => __('View Sessions'),
      'all_items'           => __('All Sessions'),
      'search_items'        => __('Search Sessions'),
      'parent_item_colon'   => __('Parent Sessions'),
      'not_found'           => __('No Sessions found.'),
      'not_found_in_trash'  => __('No Sessions found in Trash.'),
    ],
    'public'        => true,
    'query_var'     => true,
    'has_archive'   => false,
    'menu_icon'     => 'dashicons-welcome-learn-more',
    'supports'      => array('title', 'editor', 'author'),

    ]);
}

add_action('init', __NAMESPACE__ . '\\sessions_post_type');
