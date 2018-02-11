<?php
/**
 * Custom post types and taxonomies
 */

function lippukuntateema_cpt_event() {
  $labels = array(
    'name' => 'Tapahtumat',
    'singular_name' => 'Tapahtuma',
    'menu_name' => 'Tapahtumat',
    'name_admin_bar' => 'Tapahtuma',
    'archives' => 'Tapahtuma Arkistot',
    'all_items' => 'Kaikki Tapahtumat',
    'add_new_item' => 'Lisää uusi',
    'add_new' => 'Lisää uusi',
    'new_item' => 'Lisää uusi',
    'edit_item' => 'Muokkaa',
    'update_item' => 'Päivitä',
    'view_item' => 'Näytä',
    'search_items' => 'Etsi',
    'not_found' => 'Ei tuloksia',
    'featured_image' => 'Tapahtumakuva',
    'set_featured_image' => 'Aseta tapahtumakuva',
    'remove_featured_image' => 'Poista tapahtumakuva'
  );

  $args = array(
    'label' => 'Tapahtuma',
    'labels' => $labels,
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-megaphone',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => false,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'rewrite' => array(
                  'slug' => 'tapahtumat',
                  'with_front' => false,
                  'pages' => true,
                  'feeds' => true,
                 ),
  );

  register_post_type('event', $args);
}
add_action('init', 'lippukuntateema_cpt_event', 0);

function lippukuntateema_tax_events_category() {
  $labels = array(
    'name'                       => 'Item',
    'singular_name'              => 'Item',
    'menu_name'                  => 'Item',
    'all_items'                  => 'Items',
    'parent_item'                => 'Parent Item',
    'parent_item_colon'          => 'Parent Item:',
    'new_item_name'              => 'New Item Name',
    'add_new_item'               => 'Add New Item',
    'edit_item'                  => 'Edit Item',
    'update_item'                => 'Update Item',
    'view_item'                  => 'View Item',
    'separate_items_with_commas' => 'Separate items with commas',
    'add_or_remove_items'        => 'Add or remove items',
    'choose_from_most_used'      => 'Choose from the most used',
    'popular_items'              => 'Popular Items',
    'search_items'               => 'Search Items',
    'not_found'                  => 'Not Found',
    'no_terms'                   => 'No items',
    'items_list'                 => 'Items list',
    'items_list_navigation'      => 'Items list navigation',
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => false,
    'show_tagcloud'              => false,
    'rewrite'                    => array(
                                      'slug'         => 'tapahtumat',
                                      'with_front'   => false,
                                      'hierarchical' => false,
                                   ),
  );
  register_taxonomy('events-category', array('event'), $args);
}
// add_action('init', 'lippukuntateema_tax_events_category', 0);
